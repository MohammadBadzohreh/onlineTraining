<?php

namespace Badzohreh\Payment\Repositories;

use Badzohreh\Payment\Models\Payment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\Jalalian;
use Morilog\Jalali\Tests\JalalianTest;

class PaymentRepo
{

    private $query;

    public function __construct()
    {
        $this->query = Payment::query();

    }

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
            "seller_id" => $data["seller_id"]
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


    public function paginate($per_page = 15)
    {
        return $this->query->paginate($per_page);
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

    private function acceptedPaymentsQuery($status = Payment::STATUS_ACCEPTED)
    {
        return Payment::query()
            ->where("status", $status);
    }

    public function get_payment_by_day($day)
    {
        return Payment::query()->whereDay("created_at", $day);
    }

    public function get_total_success_payment_by_day($day)
    {

        return $this
            ->get_payment_by_day($day)
            ->where("status", Payment::STATUS_ACCEPTED)->sum("amount");
    }

    public function get_success_site_share_total_payment_by_day($day)
    {
        return $this
            ->get_payment_by_day($day)
            ->where("status", Payment::STATUS_ACCEPTED)->sum("site_share");
    }

    public function get_success_seller_share_total_payment_by_day($day)
    {
        return $this
            ->get_payment_by_day($day)
            ->where("status", Payment::STATUS_ACCEPTED)->sum("seller_share");
    }

    public function allPamentsSellerShare()
    {
        return $this->acceptedPaymentsQuery()->sum("seller_share");
    }

    public function getsummary($dates, $user_id = null)
    {


        $query = Payment::query()->where("created_at", ">=", $dates->keys()->first());

        if (!is_null($user_id)) {
            $query = $query->where("seller_id", $user_id);
        }
        $payments = $query->orderBy("date")
            ->groupBy("date")
            ->get([
                DB::raw("DATE(created_at) as date"),
                DB::raw("SUM(site_share) as totalSiteShare"),
                DB::raw("SUM(seller_share) as totalSellerShare"),
                DB::raw("SUM(amount) as amount"),
            ]);

        return $payments;


    }

    public function searchEmail($email)
    {
        if (!is_null($email)) {
            $this->query->select("payments.*", "users.email")->join("users", "users.id", "=", "payments.buyer_id")
                ->where("email", "like", "%" . $email . "%");
        }
        return $this;
    }

    public function searchAmount($amount)
    {
        if (!is_null($amount)) {
            $this->query->where("amount", $amount);
        }
        return $this;
    }

    public function searchInvoiceId($invoice_id)
    {
        if (!is_null($invoice_id)) {
            $this->query->where("invoice_id", "like", "%" . $invoice_id . "%");
        }
        return $this;
    }

    public function searchStartDate($startDate)
    {

        $start_date = $startDate ? Jalalian::fromFormat("Y/m/d", $startDate)->toCarbon() : null;
        if (!is_null($start_date)) {
            $this->query->whereDate("payments.created_at", ">=", $start_date);
        }
        return $this;
    }


    public function searchEndDate($startDate)
    {

        $start_date = $startDate ? Jalalian::fromFormat("Y/m/d", $startDate)->toCarbon() : null;
        if (!is_null($start_date)) {
            $this->query->whereDate("payments.created_at", "<=", $start_date);
        }
        return $this;

    }


//    search by user payments

    public function getSuccessPaymentsByUser($id)
    {
        return Payment::query()
            ->where("seller_id", $id)
            ->where("status", Payment::STATUS_ACCEPTED);
    }


    public function getUserTotalSales($id)
    {
        return $this->getSuccessPaymentsByUser($id)
            ->sum("amount");
    }

    public function getUserTotalSiteShare($id)
    {
        return $this->getSuccessPaymentsByUser($id)
            ->sum("site_share");
    }


    public function getUserTotalSellerShare($id)
    {
        return $this->getSuccessPaymentsByUser($id)
            ->sum("seller_share");
    }

    public function getUserBenefit($id)
    {
        return $this->getSuccessPaymentsByUser($id)
            ->whereDate("created_at", now())
            ->sum("seller_share");
    }

    public function getUserTodaySuccessPaymensCount($id)
    {
        return $this->getSuccessPaymentsByUser($id)
            ->whereDate("created_at", now())
            ->count();
    }

    public function getUserTodaySales($id)
    {
        return $this->getSuccessPaymentsByUser($id)
            ->whereDate("created_at", now())
            ->sum("amount");
    }

    public function getUserPeriodDaysBenefit($id, $period = 30)
    {
        return $this->getSuccessPaymentsByUser($id)
            ->whereDate("created_at", ">=", Carbon::now()->subDays($period))
            ->sum("seller_share");
    }

    public function findLastetPaymentsUser($user_id)
    {
        return Payment::query()
            ->with(["paymentable", "buyer"])
            ->where("seller_id", $user_id)
            ->latest()
            ->get();
    }

}
