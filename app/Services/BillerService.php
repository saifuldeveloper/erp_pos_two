<?php

namespace App\Services;

use App\Mail\BillerCreate;
use App\Models\Biller;
use App\Models\MailSetting;
use App\Repositories\Contracts\BillerRepositoryInterface;
use App\Traits\CacheForget;
use App\Traits\FileHandleTrait;
use App\Traits\MailInfo;
use App\Traits\TenantInfo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;

class BillerService
{
    use CacheForget;
    use FileHandleTrait;
    use MailInfo;
    use TenantInfo;

    protected BillerRepositoryInterface $billerRepository;

    /**
     * BillerService constructor.
     *
     * @param BillerRepositoryInterface $billerRepository
     */
    public function __construct(BillerRepositoryInterface $billerRepository)
    {
        $this->billerRepository = $billerRepository;
    }

    /**
     * Get all active billers.
     *
     * @return Collection
     */
    public function getActiveBillers(): Collection
    {
        return $this->billerRepository->getActiveBillers();
    }

    /**
     * Get biller by ID.
     *
     * @param int|string $id
     * @return Biller
     */
    public function getBillerById($id): Biller
    {
        return $this->billerRepository->findOrFail($id);
    }

    /**
     * Create a new biller.
     *
     * @param array $requestData
     * @param UploadedFile|null $image
     * @return array
     */
    public function createBiller(array $requestData, ?UploadedFile $image): array
    {
        $billerData = $requestData;
        unset($billerData['image']);
        $billerData['is_active'] = true;

        if ($image) {
            $ext = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $imageName = date("Ymdhis");
            if (!config('database.connections.saas_landlord')) {
                $imageName = $imageName . '.' . $ext;
                $image->move(public_path('images/biller'), $imageName);
            } else {
                $imageName = $this->getTenantId() . '_' . $imageName . '.' . $ext;
                $image->move(public_path('images/biller'), $imageName);
            }
            $billerData['image'] = $imageName;
        }

        $biller = $this->billerRepository->create($billerData);
        $this->cacheForget('biller_list');

        $mailSetting = MailSetting::latest()->first();
        $message = $this->mailAction($billerData, $mailSetting);

        return [
            'biller'  => $biller,
            'message' => $message
        ];
    }

    /**
     * Update an existing biller.
     *
     * @param int|string $id
     * @param array $requestData
     * @param UploadedFile|null $image
     * @return Biller
     */
    public function updateBiller($id, array $requestData, ?UploadedFile $image): Biller
    {
        $biller = $this->billerRepository->findOrFail($id);
        $input = $requestData;
        unset($input['image']);

        if ($image) {
            $this->fileDelete('images/biller/', $biller->image);

            $ext = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $imageName = date("Ymdhis");
            if (!config('database.connections.saas_landlord')) {
                $imageName = $imageName . '.' . $ext;
                $image->move(public_path('images/biller'), $imageName);
            } else {
                $imageName = $this->getTenantId() . '_' . $imageName . '.' . $ext;
                $image->move(public_path('images/biller'), $imageName);
            }
            $input['image'] = $imageName;
        }

        $biller->update($input);
        $this->cacheForget('biller_list');

        return $biller;
    }

    /**
     * Import billers from CSV.
     *
     * @param UploadedFile $file
     * @return string
     */
    public function importBillers(UploadedFile $file): string
    {
        $filePath = $file->getRealPath();
        $handle = fopen($filePath, 'r');
        $header = fgetcsv($handle);
        $escapedHeader = [];

        foreach ($header as $value) {
            $lheader = strtolower($value);
            $escapedItem = preg_replace('/[^a-z]/', '', $lheader);
            $escapedHeader[] = $escapedItem;
        }

        $mailSetting = MailSetting::latest()->first();
        $message = 'Data inserted successfully';

        while ($columns = fgetcsv($handle)) {
            if ($columns[0] == '') {
                continue;
            }
            foreach ($columns as $key => $value) {
                $columns[$key] = preg_replace('/\D/', '', $value);
            }
            $data = array_combine($escapedHeader, $columns);

            $biller = $this->billerRepository->firstOrNew(['company_name' => $data['companyname']]);
            $biller->name = $data['name'];
            $biller->image = $data['image'];
            $biller->vat_number = $data['vatnumber'] ?? null;
            $biller->email = $data['email'] ?? null;
            $biller->phone_number = $data['phonenumber'];
            $biller->address = $data['address'];
            $biller->city = $data['city'];
            $biller->state = $data['state'] ?? null;
            $biller->postal_code = $data['postalcode'] ?? null;
            $biller->country = $data['country'] ?? null;
            $biller->is_active = true;
            $biller->save();

            $message = $this->mailAction($data, $mailSetting);
        }

        fclose($handle);
        $this->cacheForget('biller_list');

        return $message;
    }

    /**
     * Deactivate a biller and delete its image.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteBiller($id): bool
    {
        $biller = $this->billerRepository->find($id);
        if ($biller) {
            $this->fileDelete('images/biller/', $biller->image);
            $this->billerRepository->deactivate($id);
            $this->cacheForget('biller_list');
            return true;
        }
        return false;
    }

    /**
     * Deactivate multiple billers and delete images.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteMultipleBillers(array $ids): bool
    {
        foreach ($ids as $id) {
            $biller = $this->billerRepository->find($id);
            if ($biller) {
                $this->fileDelete('images/biller/', $biller->image);
            }
        }

        $result = $this->billerRepository->deactivateMultiple($ids);
        $this->cacheForget('biller_list');

        return $result;
    }

    /**
     * Send notification email.
     */
    protected function mailAction($data, $mailSetting): string
    {
        $message = 'Data inserted successfully';
        if (!$mailSetting) {
            $message = 'Data inserted successfully. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
        } elseif (!empty($data['email']) && $mailSetting) {
            try {
                $this->setMailInfo($mailSetting);
                Mail::to($data['email'])->send(new BillerCreate($data));
            } catch (\Exception $e) {
                $message = $e->getMessage();
            }
        }

        return $message;
    }
}
