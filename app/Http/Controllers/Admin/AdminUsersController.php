<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminUsersController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('passport-administrators');
    }

    public function index(Request $request)
    {
        dd($request->user('admin_user_api'));
        //dd(\Auth::guard('admin_user_api')->id());
    }
}
