<?php

namespace Badzohreh\Payment\Http\Controllers;

use App\Http\Controllers\Controller;
use Badzohreh\Payment\Http\Requests\StoreSattlementRequest;
use Badzohreh\Payment\Http\Requests\UpdateSattlemetnRequest;
use Badzohreh\Payment\Models\Settlement;
use Badzohreh\Payment\Repositories\SattlementRepo;
use Badzohreh\Payment\Services\SettlementServices;
use Illuminate\Http\Request;

class SettlementController extends Controller
{
    private $sattlementRepo;

    public function __construct(SattlementRepo $sattlementRepo)
    {

        $this->sattlementRepo = $sattlementRepo;
    }

    public function index(Request $request)
    {
        $query = $this->sattlementRepo;

        if ($request->has("status") && $request->status = Settlement::STATUS_SATTELED) {
            $query = $query->sattled();
        }
        $settlements = $query->lastet()->paginate();
        return view("Payment::settlements.index", compact("settlements"));
    }


    public function create()
    {
        return view("Payment::settlements.settlement");
    }


    public function store(StoreSattlementRequest $request)
    {
        $this->sattlementRepo->store([
            "name" => $request->name,
            "cart_number" => $request->cart_number,
            "amount" => $request->amount,
        ]);

        auth()->user()->balance -= $request->amount;
        auth()->user()->save();

        return redirect()->route("home");
    }

    public function edit($sattlement)
    {
        $sattlement = $this->sattlementRepo->find($sattlement);
        return view("Payment::settlements.edit", compact("sattlement"));
    }

    public function update($settlement, UpdateSattlemetnRequest $request)
    {
        SettlementServices::update($settlement, $request->all());

        return redirect()->route("settlement.index");
    }
}
