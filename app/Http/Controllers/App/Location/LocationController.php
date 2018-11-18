<?php

namespace App\Http\Controllers\App\Location;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class LocationController
 * @package App\Http\Controllers\App\Location
 */
class LocationController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('app.location.location');
    }
}
