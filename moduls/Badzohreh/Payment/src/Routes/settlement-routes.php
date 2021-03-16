<?php
Route::group([], function ($router) {
    $router->get("/payments/settlement/create", [
        "uses" => "SettlementController@create",
        "as" => "settlement.create"
    ]);
    $router->post("/payments/settlement/store", [
        "uses" => "SettlementController@store",
        "as" => "settlement.store",
    ]);

    $router->get("/payments/settlement", [
        "uses" => "SettlementController@index",
        "as" => "settlement.index",
    ]);

    $router->get("/payments/settlement/{sattlement}/edit", [
        "uses" => "SettlementController@edit",
        "as" => "settlement.edit",
    ]);

    $router->put("/payments/settlement/{sattlement}/update", [
        "uses" => "SettlementController@update",
        "as" => "settlement.update",
    ]);
});
