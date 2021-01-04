<?php

namespace Badzohreh\Payment\Http\Controllers;

use App\Http\Controllers\Controller;
use Badzohreh\Payment\Events\SuccessfulPayment;
use Badzohreh\Payment\Gateways\Gateway;
use Badzohreh\Payment\Models\Payment;
use Badzohreh\Payment\Repositories\PaymentRepo;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function callback(Request $request)
    {
        $gateway = resolve(Gateway::class);
        $paymentRepo = new PaymentRepo();
        $payment = $paymentRepo->findByInvoiceId($gateway->getInvoiceIdFromRequest($request));
        if (!$payment) {
            showFeedbacks("تراکنش ناموفق", "تراکنش مورد نظر یافت نشد.");
            return redirect("/");
        }
        $reslut = $gateway->verify($payment);
        if (is_array($reslut)) {
            showFeedbacks("عملیات ناموفق", $reslut["message"]);
            $paymentRepo->changeStatus($payment->id, Payment::STATUS_FAIL);
        } else {
            event(new SuccessfulPayment($payment));
            showFeedbacks("عملیات موفقیت آمیز", "پرداخت با موفقیت انجام شد.");
            $paymentRepo->changeStatus($payment->id, Payment::STATUS_ACCEPTED);
        }
        return redirect()->to($payment->paymentable->path());
    }

    public function index(PaymentRepo $paymentRepo)
    {
        $payments = $paymentRepo->paginate();
        $alllast30DaysPayments = $paymentRepo->allPayments(30);
        $allPayments = $paymentRepo->allPayments();
        $alllast30DaysPaymentsSite = $paymentRepo->allPaymentsSite(30);
        $allPaymentsSite = $paymentRepo->allPaymentsSite();
        return view("Payment::index",
            compact(
                "payments",
                "alllast30DaysPayments",
                "alllast30DaysPaymentsSite",
                "allPaymentsSite",
                "allPayments"
            ));
    }

}
