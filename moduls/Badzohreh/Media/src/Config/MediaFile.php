<?php
return [
    "mediaTypeService" => [
        "image" => [
            "extentions" => ["png", "jpg", "jpeg"],
            "handler" => \Badzohreh\Media\Services\ImageServices::class,
        ],
        "video" => [
            "extentions" => ["mp4", "mkv", "avi"],
            "handler" => \Badzohreh\Media\Services\VideoServices::class
        ],
        "zip"=>[
            "extentions"=>["zip","rar","tar"],
            "handler"=>\Badzohreh\Media\Services\CompressServcie::class,
        ]
    ]
];