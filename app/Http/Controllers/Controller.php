<?php

namespace App\Http\Controllers;
use OpenApi\Attributes as OA;

#[
    OA\Info(version: "1.0.0", description: "Nfc locks", title: "Nfc locks api"),
    OA\Schema(format:"https"),    
    OA\Server(url: 'http://blog.test/api', description: "local server"),
    OA\SecurityScheme( securityScheme: 'bearerAuth', type: "http", name: "Authorization", in: "header", scheme:"Bearer", description: "Authorize with bearer token"),
    OA\Contact(email: "tcom.developer@gmail.com")
]

abstract class Controller
{
    //
}
