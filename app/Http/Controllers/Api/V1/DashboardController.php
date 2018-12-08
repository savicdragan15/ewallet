<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\User;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 *
 * @property User user
 * @property Order order
 * @package App\Http\Controllers\Api\V1
 */
class DashboardController extends Controller
{

    /**
     * DashboardController constructor.
     *
     * @param Order $order
     * @param User $user
     * @param Request $request
     */
    public function __construct(Order $order, User $user, Request $request)
    {
        $this->order = $order;
        $this->user = $user->findOrFail($request->header('user'));
    }

    /**
     * Return number of orders for user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNumberOfOrders()
    {
        return response()->json(
            [
            'numberOfOrders' => $this->order->getNumberOfOrders($this->user),
            'allOrdersUrl' => route('order')
            ]
        );
    }

    /**
     * Return spent money for user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSpentMoney()
    {
        return response()->json($this->order->getSpentMoney($this->user));
    }

    /**
     * Return latest orders for user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLatestOrders()
    {
        return response()->json($this->order->getLatestOrders($this->user));
    }
}
