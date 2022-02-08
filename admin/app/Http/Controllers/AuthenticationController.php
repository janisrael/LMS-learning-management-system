<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Middleware\AppAuth;

class AuthenticationController extends Controller
{
    public function __construct()
    {
//        $this->middleware(AppAuth::class);
    }
}
