<?php

namespace Badzohreh\Payment\Repositories;

use Badzohreh\Payment\Models\Payment;

class PaymentRepo
{
    public static function store($data)
    {
        return Payment::create([
            "buyer_id" => $data["buyer_id"],
            "paymentable_id" => $data["paymentable_id"],
            "paymentable_type" => $data["paymentable_type"],
            "amount" => $data["amount"],
            "invoice_id" => $data["invoice_id"],
            "getway" => $data["getway"],
            "status" => $data["status"],
            "seller_percent" => $data["seller_percent"],
            "seller_share" => $data["seller_share"],
            "site_share" => $data["site_share"],
        ]);
    }

    public function findByInvoiceId($invoiceId)
    {
        return Payment::query()->where("invoice_id", $invoiceId)->first();
    }

    public function changeStatus($id, string $status)
    {
        return Payment::query()->where("id", $id)->update([
            "status" => $status
        ]);
    }

    public function paginate()
    {
        return Payment::query()->latest()->paginate();
    }


    public function allPayments($days = null)
    {
        $query = $this->acceptedPaymentsQuery();
        if (!is_null($days)) {
            $query = $query->where("created_at", ">=", now()->subDays($days));
        }
        return $query->sum("amount");
    }


    public function allPaymentsSite($days = null)
    {
        $query = $this->acceptedPaymentsQuery();
        if (!is_null($days)) {
            $query = $query->where("created_at", ">=", now()->subDays($days));
        }
        return $query->sum("site_share");
    }


//privates

    private function acceptedPaymentsQuery($status = Payment::STATUS_ACCEPTED)
    {
        return Payment::query()
            ->where("status", $status);
    }


}
