<?php

namespace App\Http\Controllers\App\Profile;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('app.profile.profile');
    }
}
