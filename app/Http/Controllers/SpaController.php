<?php

namespace App\Http\Controllers;

/**
 * Class SpaController
 * @package App\Http\Controllers
 */
class SpaController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('vendor.adminlte.page');
    }
}
