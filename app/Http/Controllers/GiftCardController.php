<?php

namespace App\Http\Controllers;

use App\Http\Requests\GiftCard\StoreGiftCardRequest;
use App\Http\Requests\GiftCard\UpdateGiftCardRequest;
use App\Models\GiftCard;
use App\Services\GiftCardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class GiftCardController extends Controller
{
    protected GiftCardService $giftCardService;

    public function __construct(GiftCardService $giftCardService)
    {
        $this->giftCardService = $giftCardService;
    }

    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('unit') || $role->hasPermissionTo('gift_card')) {
            $indexData = $this->giftCardService->getIndexData();
            return view('backend.gift_card.index', $indexData);
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function generateCode()
    {
        return $this->giftCardService->generateCode();
    }

    public function store(StoreGiftCardRequest $request)
    {
        $this->giftCardService->createGiftCard($request->all());

        return redirect('gift_cards')->with('message', 'GiftCard created successfully');
    }

    public function edit($id)
    {
        return GiftCard::find($id);
    }

    public function update(UpdateGiftCardRequest $request, $id)
    {
        $this->giftCardService->updateGiftCard($request->gift_card_id, $request->all());

        return redirect('gift_cards')->with('message', 'GiftCard updated successfully');
    }

    public function recharge(Request $request, $id)
    {
        $this->giftCardService->rechargeGiftCard($request->all());

        return redirect('gift_cards')->with('message', 'GiftCard recharged successfully');
    }

    public function destroy($id)
    {
        $this->giftCardService->deleteGiftCard($id);

        return redirect('gift_cards')->with('not_permitted', 'GiftCard deleted successfully');
    }
}
