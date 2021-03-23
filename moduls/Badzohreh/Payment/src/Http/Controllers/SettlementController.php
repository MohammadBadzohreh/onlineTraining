<?php

namespace Badzohreh\Payment\Http\Controllers;

use App\Http\Controllers\Controller;
use Badzohreh\Payment\Http\Requests\StoreSattlementRequest;
use Badzohreh\Payment\Http\Requests\UpdateSattlemetnRequest;
use Badzohreh\Payment\Models\Settlement;
use Badzohreh\Payment\Repositories\SattlementRepo;
use Badzohreh\Payment\Services\PaymentServices;
use Badzohreh\Payment\Services\SettlementServices;
use Badzohreh\RolePermissions\Models\Permission;
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
        $this->authorize("index", Settlement::class);
        $query = $this->sattlementRepo;
        if ($request->has("status") && $request->status == "satteled") {
            $query = $query->sattled();
        }
        if (!auth()->user()->hasPermissionTo(Permission::PERMISSION_SUPER_ADMIN))
            $query = $query->findMylatestSattlements(auth()->id());

        $settlements = $query->lastet()->paginate();

        return view("Payment::settlements.index", compact("settlements"));
    }


    public function create()
    {
        $this->authorize("create", Settlement::class);
        if (auth()->user()->exsitsPendingSettlement(auth()->id())) {
            showFeedbacks("َشما یک درخواست تسویه قابل اجرا دارید!");
            return back();
        }
        return view("Payment::settlements.settlement");
    }


    public function store(StoreSattlementRequest $request)
    {
        $this->authorize("create", Settlement::class);
        if (auth()->user()->exsitsPendingSettlement(auth()->id())) {
            showFeedbacks("َشما یک درخواست تسویه قابل اجرا دارید!");
            return back();
        }
        SettlementServices::store($request->all());
        return redirect()->route("home");
    }

    public function edit($sattlement)
    {

        $this->authorize("edit", Settlement::class);
        $sattlement = $this->sattlementRepo->find($sattlement);

        $lastSattlement = $this->sattlementRepo->getLastSattlement($sattlement->user->id);

        if (!is_null($lastSattlement) && $sattlement->id != $lastSattlement->id) {
            showFeedbacks("فقط آخرین درخواست قابل ویرایش است!");
            return back();
        }


        return view("Payment::settlements.edit", compact("sattlement"));
    }

    public function update($settlement, UpdateSattlemetnRequest $request)
    {
        $this->authorize("edit", Settlement::class);

        SettlementServices::update($settlement, $request->all());

        return redirect()->route("settlement.index");
    }
}
