<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function getSessionData()
    {
        return response()->json(\Auth::user());
    }
}
