<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ActiveUserController extends Controller
{
    //
    public function AdminAllUser(){

        $users = User::where('role', 'user')->latest()->get();
        return view('admin.backend.users.all_users', compact('users'));
    }

    public function AdminAllInstructor(){

        $instructors = User::where('role', 'instructor')->latest()->get();
        return view('admin.backend.users.all_instructors', compact('instructors'));
    }
}
