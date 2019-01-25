<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Transformers\OrderTransformer;
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
        $this->user = $user->find($request->header('user'));
    }

    /**
     * Return number of orders for user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNumberOfOrdersCurrentMonth()
    {
        return response()->json($this->order->getNumberOfOrdersCurrentMonth($this->user));
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
     * Return spent money for user in current month
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSpentMoneyCurrentMonth()
    {
        return response()->json($this->order->getSpentMoneyCurrentMonth($this->user));
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSumOrdersByMonth(Request $request)
    {
        $limit = $request->has('limit') && !is_null($request->input('limit')) ? (int)$request->input('limit') : 12;
        return response()->json(
           OrderTransformer::transformForChart($this->order
               ->getSumOrdersByMonth($this->user, $limit))
        );
    }
}
