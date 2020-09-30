<?php

function showFeedbacks(string $title="عملیات موفقیت آمیز",string $body="با موفقیت انجام شد."){
    session()->flash("feedbacks",compact("title","body"));
}