<?php


namespace Badzohreh\Payment\Services;


use Badzohreh\Payment\Models\Settlement;
use Badzohreh\Payment\Repositories\SattlementRepo;

class SettlementServices
{

    public static function store($data)
    {
        $sattlementRepo = new SattlementRepo();

        $sattlementRepo->store([
            "name" => $data["name"],
            "cart_number" => $data["cart_number"],
            "amount" => $data["amount"],
        ]);

        auth()->user()->balance -= $data["amount"];
        auth()->user()->save();
    }


    public static function update(int $settlement_id, array $data)
    {
        $settlementRepo = new SattlementRepo();
        $sattlement = $settlementRepo->find($settlement_id);

        if ($sattlement->amount > $sattlement->user->balance && $data["status"] == Settlement::STATUS_SATTELED) {
            showFeedbacks("موجودی ناکافی", "شما قادر به انجام این کار نمی باشید");
            return back();
        }

        if (!in_array($sattlement->status, [Settlement::STATUS_CANCELLED, Settlement::STATUS_REJECTED]) &&
            in_array($data["status"], [Settlement::STATUS_CANCELLED, Settlement::STATUS_REJECTED])) {

            $sattlement->user->balance += $sattlement->amount;
            $sattlement->user->save();
        }

        if ($data["status"] == Settlement::STATUS_SATTELED &&
            !in_array($sattlement->status, [Settlement::STATUS_PENDING, Settlement::STATUS_SATTELED])) {
            $sattlement->user->balance -= $sattlement->amount;
            $sattlement->user->save();
        }


        if ($settlementRepo->update($settlement_id, $data)) {
            showFeedbacks();

        }
    }
}
