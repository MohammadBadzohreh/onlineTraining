<?php

Route::get("/discounts", [
    "uses" => "DiscountController@index",
    "as" => "discount.index"
]);
