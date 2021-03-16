<?php

namespace Badzohreh\Payment\Repositories;


use Badzohreh\Payment\Models\Settlement;
use Hamcrest\Core\Set;
use Monolog\Handler\IFTTTHandler;

class SattlementRepo
{
    private $query;

    public function __construct()
    {
        $this->query = Settlement::query();
    }

    public function paginate()
    {
        return $this->query->paginate();
    }

    public function store(array $data)
    {
        Settlement::query()->create([
            "user_id" => auth()->id(),
            "from" => [
                "name" => $data["name"],
                "cart_number" => $data["cart_number"],
            ],
            "amount" => $data["amount"],
        ]);
    }

    public function sattled()
    {
        $this->query->where("status", Settlement::STATUS_SATTELED);

        return $this;
    }

    public function find($id)
    {
        return $this->query->findOrFail($id);
    }

    public function update(int $settlement, array $data)
    {
        $sattlement = $this->find($settlement);


        return $sattlement->update([
            "to" => $data["to"],
            "from" => $data["from"],
            "amount" => $data["amount"],
            "status" => $data["status"],
        ]);
    }

    public function lastet()
    {
        return $this->query->latest();
    }

    public function getLastSattlement($user_id)
    {
        return Settlement::query()
            ->where("user_id", $user_id)
            ->latest()
            ->first();
    }
}
