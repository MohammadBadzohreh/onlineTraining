<?php

function showFeedbacks(string $title,string $body){
    session()->flash("feedbacks",compact("title","body"));
}