<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\GiftCard;
use App\Models\GiftCardRecharge;
use App\Models\User;
use App\Repositories\Contracts\GiftCardRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Keygen\Keygen;

class GiftCardService
{
    protected GiftCardRepositoryInterface $giftCardRepository;

    /**
     * GiftCardService constructor.
     *
     * @param GiftCardRepositoryInterface $giftCardRepository
     */
    public function __construct(GiftCardRepositoryInterface $giftCardRepository)
    {
        $this->giftCardRepository = $giftCardRepository;
    }

    /**
     * Get index data for gift card view.
     *
     * @return array
     */
    public function getIndexData(): array
    {
        $lims_customer_list = Customer::where('is_active', true)->get();
        $lims_user_list = User::where('is_active', true)->get();
        $lims_gift_card_all = $this->giftCardRepository->getActiveGiftCards();

        return compact('lims_customer_list', 'lims_user_list', 'lims_gift_card_all');
    }

    /**
     * Generate unique numeric gift card code.
     *
     * @return string
     */
    public function generateCode(): string
    {
        return Keygen::numeric(16)->generate();
    }

    /**
     * Create gift card.
     *
     * @param array $requestData
     * @return GiftCard
     */
    public function createGiftCard(array $requestData): GiftCard
    {
        $data = $requestData;
        if (!empty($data['user'])) {
            $data['customer_id'] = null;
        } else {
            $data['user_id'] = null;
        }

        $data['is_active'] = true;
        $data['created_by'] = Auth::id();
        $data['expense'] = 0;

        $giftCard = $this->giftCardRepository->create($data);

        // Optional email notification
        try {
            if ($data['user_id']) {
                $user = User::find($data['user_id']);
                if ($user && $user->email) {
                    $data['email'] = $user->email;
                    $data['name'] = $user->name;
                    Mail::send('mail.gift_card_create', $data, function ($message) use ($data) {
                        $message->to($data['email'])->subject('GiftCard');
                    });
                }
            } else {
                $customer = Customer::find($data['customer_id']);
                if ($customer && $customer->email) {
                    $data['email'] = $customer->email;
                    $data['name'] = $customer->name;
                    Mail::send('mail.gift_card_create', $data, function ($message) use ($data) {
                        $message->to($data['email'])->subject('GiftCard');
                    });
                }
            }
        } catch (\Exception $e) {
            // Email failure handled safely without interrupting transaction
        }

        return $giftCard;
    }

    /**
     * Recharge existing gift card.
     *
     * @param array $requestData
     * @return GiftCardRecharge
     */
    public function rechargeGiftCard(array $requestData): GiftCardRecharge
    {
        $giftCard = $this->giftCardRepository->findOrFail($requestData['gift_card_id']);
        $giftCard->amount += $requestData['amount'];
        $giftCard->save();

        return GiftCardRecharge::create([
            'gift_card_id' => $requestData['gift_card_id'],
            'amount'       => $requestData['amount'],
            'user_id'      => Auth::id(),
        ]);
    }

    /**
     * Update an existing gift card.
     *
     * @param int|string $id
     * @param array $requestData
     * @return GiftCard
     */
    public function updateGiftCard($id, array $requestData): GiftCard
    {
        $data = $requestData;
        if (!empty($data['user'])) {
            $data['customer_id'] = null;
        } else {
            $data['user_id'] = null;
        }

        $giftCard = $this->giftCardRepository->findOrFail($id);
        $giftCard->update($data);

        return $giftCard;
    }

    /**
     * Delete a gift card.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteGiftCard($id): bool
    {
        $giftCard = $this->giftCardRepository->findOrFail($id);
        $giftCard->is_active = false;

        return (bool) $giftCard->save();
    }
}
