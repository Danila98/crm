<?php

namespace App\Http\Controllers\Api\Trainer;

use App\Http\Controllers\Api\ApiController;

abstract class TrainerController extends ApiController
{
    public function __construct()
    {
        $this->middleware('jwt.auth.trainer');
    }
}
