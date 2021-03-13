<?php


namespace Badzohreh\Payment\Services;


use Badzohreh\Payment\Models\Settlement;
use Badzohreh\Payment\Repositories\SattlementRepo;

class SettlementServices
{
    public static function update(int $settlement_id, $data)
    {
        $settlementRepo = new SattlementRepo();
        $sattlement = $settlementRepo->find($settlement_id);

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

        $settlementRepo->update($settlement_id, $data);
    }
}
