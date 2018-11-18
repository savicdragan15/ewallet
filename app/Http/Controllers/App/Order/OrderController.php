<?php

namespace App\Http\Controllers\App\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class OrderController
 * @package App\Http\Controllers\App\Order
 */
class OrderController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('app.order.order');
    }
}
