<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;

abstract class AdminController extends ApiController
{
    public function __construct()
    {
        $this->middleware('jwt.auth.admin');
    }
}
