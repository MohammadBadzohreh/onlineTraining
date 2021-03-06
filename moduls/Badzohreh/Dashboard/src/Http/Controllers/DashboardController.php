<?php


namespace Badzohreh\Dashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Badzohreh\Payment\Repositories\PaymentRepo;

class DashboardController extends Controller
{
    public function index(PaymentRepo $paymentRepo)
    {
        $totalUserSales = $paymentRepo->getUserTotalSales(auth()->id());

        $totalUserSiteShare = $paymentRepo->getUserTotalSiteShare(auth()->id());

        $getUserTotalSellerShare = $paymentRepo->getUserTotalSellerShare(auth()->id());

        $getUserToadySales = $paymentRepo->getUserBenefit(auth()->id());

        $getUser30DaysBenefit = $paymentRepo->getUserPeriodDaysBenefit(auth()->id());

        $todaySUseruccessCount = $paymentRepo->getUserTodaySuccessPaymensCount(auth()->id());

        $getUserTodaySales = $paymentRepo->getUserTodaySales(auth()->id());

        $payments = $paymentRepo->findLastetPaymentsUser(auth()->id());

        $dates = collect();
        foreach (range(-30, 0) as $i) {
            $dates->put(now()->addDays($i)->format("Y-m-d"), 0);
        }
        $summry = $paymentRepo->getsummary($dates, auth()->id());

        return view('Dashboard::index', compact("totalUserSales",
                "totalUserSiteShare",
                "getUserTotalSellerShare",
                "getUserToadySales",
                "getUser30DaysBenefit",
                "todaySUseruccessCount",
                "dates",
                "summry",
                "getUserTodaySales",
                "payments"
            )
        );
    }
}
