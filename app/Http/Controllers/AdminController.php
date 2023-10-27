<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function warning() {
        return view("warnings.admin_access_not_allowed");
    }
}
