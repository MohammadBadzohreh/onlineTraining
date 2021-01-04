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
}
