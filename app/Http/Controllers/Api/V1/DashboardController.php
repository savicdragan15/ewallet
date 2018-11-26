<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\User;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @property User user
 * @property Order order
 * @package App\Http\Controllers\Api\V1
 */
class DashboardController extends Controller
{

    /**
     * DashboardController constructor.
     * @param Order $order
     */
    public function __construct(Order $order, User $user)
    {
        $this->order = $order;
        $this->user = $user;
    }

    /**
     * Get number of orders for user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNumberOfOrders(Request $request)
    {
        $user = $this->user->findOrFail($request->header('user'));

        return response()->json(
            [
            'numberOfOrders' => $this->order->getNumberOfOrders($user),
            'allOrdersUrl' => route('order')
            ]
        );
    }

    /**
     * Get spent money for user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSpentMoney(Request $request)
    {
        $user = $this->user->findOrFail($request->header('user'));

        return response()->json($this->order->getSpentMoney($user));
    }
}
