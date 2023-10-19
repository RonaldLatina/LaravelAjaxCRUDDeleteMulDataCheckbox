<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data['users'] = User::get();
        return view('home', $data);
    }

    public function removeMulti(Request $request)
    {
        $ids = $request->ids;
        User::whereIn('id', explode(",", $ids))->delete();
        return response()->json(['status' => true, 'message' => "User successfully removed."]);
    }
}
