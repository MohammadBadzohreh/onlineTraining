<?php


Route::group(["middleware" => ["auth"]], function ($router) {

    $router->get("/discounts", [
        "uses" => "DiscountController@index",
        "as" => "discount.index"
    ]);

    $router->post("/discount/store", [
        "uses" => "DiscountController@store",
        "as" => "discount.store"
    ]);

    $router->get("/discount/{id}/edit", [
        "uses" => "DiscountController@edit",
        "as" => "discount.edit"
    ]);

    $router->put("/discount/{id}/update", [
        "uses" => "DiscountController@update",
        "as" => "discount.update"
    ]);


    $router->delete("/discount/{id}/delete", [
        "uses" => "DiscountController@delete",
        "as" => "discount.delete"
    ]);

    $router->get("/discount/{code}/{course}/check","DiscountController@check_discount_by_code")->name("discount.check");


});

