<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

class UserController extends Controller
{


    public function __construct()
    {
    }

    public function  getUsers()
    {
        echo "Hello from getuser";
    }

    public function addUser(Request $request) {

        print ($request->firstname.' '. $request->lastname);
    }
}
