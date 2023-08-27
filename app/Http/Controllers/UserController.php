<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * Retrieve the current authenticated user
     *
     * @param Request $request
     * @return void
     */
    public function me(Request $request)
    {
        return $request->user();
    }
}
