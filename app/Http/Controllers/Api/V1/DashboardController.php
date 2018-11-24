<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Api\V1
 */
class DashboardController extends Controller
{
    /**
     * @var Order
     */
    private $order;

    /**
     * DashboardController constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get number of orders by user id
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNumberOfOrders(Request $request)
    {
        return response()->json(
            [
            'numberOfOrders' => $this->order->getNumberOfOrders($request->header('user')),
            'allOrdersUrl' => route('order')
            ]
        );
    }
}
