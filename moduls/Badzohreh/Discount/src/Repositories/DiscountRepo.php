<?php

namespace Badzohreh\Discount\Repositories;

use Badzohreh\Discount\Models\Discount;
use Morilog\Jalali\Jalalian;

class DiscountRepo
{
    public function paginate()
    {
        return Discount::query()->paginate();
    }

    public function findOrFail($discount_id)
    {
        return Discount::query()->findOrFail($discount_id);
    }

    public function store(array $data)
    {
        $discount = Discount::query()->create([
            "user_id" => auth()->id(),
            "code" => $data["code"],
            "percent" => $data["percent"],
            "expire_at" => $data["expire_at"] ? Jalalian::fromFormat("Y/n/d H:i", $data["expire_at"])->toCarbon() : null,
            "link" => $data["link"],
            "description" => $data["description"],
            "usage_limitation" => $data["usage_limitation"],
            "uses" => 0,
            "type" => $data["type"] ? $data["type"] : Discount::DISCOUNT_ALL_TYPE,
        ]);
        if (isset($data["type"]) && $data["type"] == Discount::DISCOUNT_SINGLE_TYPE) {

            $discount->courses()->sync($data["courses"]);
        }
    }

    public function update($data, $discount_id)
    {
        $discount = $this->findOrFail($discount_id);

        $discount->update([
            "user_id" => auth()->id(),
            "code" => $data["code"],
            "percent" => $data["percent"],
            "expire_at" => $data["expire_at"] ? Jalalian::fromFormat("Y/n/d H:i", $data["expire_at"])->toCarbon() : null,
            "link" => $data["link"],
            "description" => $data["description"],
            "usage_limitation" => $data["usage_limitation"],
            "uses" => 0,
            "type" => $data["type"] ? $data["type"] : Discount::DISCOUNT_ALL_TYPE,
        ]);

        if (isset($data["type"]) && $data["type"] == Discount::DISCOUNT_SINGLE_TYPE) {

            $discount->courses()->sync($data["courses"]);
        } else {
            $discount->courses()->sync([]);
        }
    }

    public function delete($discount_id)
    {
        $discount = $this->findOrFail($discount_id);

        $discount->delete();
    }


    public function getValidDiscountQuery($type = Discount::DISCOUNT_ALL_TYPE, $course_id = null)
    {
        $query = Discount::query()
            ->whereNull("code")
            ->where("expire_at", ">", now())
            ->where("type", $type)
            ->orderBy("percent", "desc");

        if ($course_id) {
            $query->whereHas("courses", function ($query) use ($course_id) {
                return $query->where("id", $course_id);
            });
        }
        return $query;
    }

    public function getAllDiscount()
    {
        return $this->getValidDiscountQuery()->first();
    }

    public function getSprecificDiscount($course_id)
    {
        return $this->getValidDiscountQuery(Discount::DISCOUNT_SINGLE_TYPE, $course_id)->first();
    }

    public function CheckValidDiscountByCode($courseId, $code)
    {
        return Discount::query()
            ->whereNotNull("code")
            ->where("code", $code)
            ->where("expire_at", ">", now())
            ->where(function ($query) use ($courseId) {
                return $query->whereHas("courses", function ($query) use ($courseId) {
                    return $query->where("id", $courseId);
                })->orWhereDoesntHave("courses");
            })->first();
    }
}
