<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Order\StoreOrder;
use App\Http\Requests\Order\UpdateOrder;
use App\Http\Services\IpStack;
use App\Models\Order;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class OrderController
 * @package App\Http\Controllers\Api\V1
 */
class OrderController extends Controller
{
    /**
     * @param  Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json(
            [
            'orders' => Order::where('user_id', $request->header('user'))
                        ->with('wallet', 'category')
                        ->orderBy('created_at', 'DESC')
                        ->paginate(15),
            'currency' => env('CURRENCY')
            ]
        );
    }

    /**
     * @param  StoreOrder $request
     * @return JsonResponse
     */
    public function store(StoreOrder $request)
    {
        try {
            $ipStack = new IpStack();
            $location = $ipStack->callApi();

            $order = Order::create(
                [
                'order_number' => 'rand',
                'wallet_id' => $request->input('wallet_id'),
                'category_id' => $request->input('category_id'),
                'user_id' => $request->input('user_id'),
                'amount' => $request->input('amount'),
                'note' => $request->input('note'),
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
                'flag' => $location->location->country_flag,
                'location_info' => json_encode($location),
                ]
            );

            cookieSet('order_last_used_wallet_' . $order->user_id, $order->wallet_id);

            $order->order_number = $order->id . '-' . Carbon::now()->format('d-m-Y');
            $order->save();
        } catch (Exception $e) {
            Bugsnag::notifyException($e);
            return response()->json(
                [
                'success' => false,
                'message' => 'Error during adding new order' . $e->getMessage(),
                ],
                400
            );
        }

        return response()->json(
            [
            'success' =>  true,
            'message' => 'Successfully added new order',
            'data'    =>  $order
            ]
        );
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $order = Order::where('id', '=', $id)->first();
        return response()->json($order);
    }

    /**
     * @param UpdateOrder $request
     * @param Order $order
     * @return Order
     */
    public function update(UpdateOrder $request, Order $order)
    {
        try {
            $order->update($request->all());
        } catch (\Exception $e) {
            Bugsnag::notifyException($e);
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Error during update order!',
                ],
                400
            );
        }

        return response()->json(
            [
                'success' => true,
                'message' => 'Order successfully save!'
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();
        } catch (Exception $e) {
            Bugsnag::notifyException($e);
            return response()->json(
                [
                'success' => false,
                'message' => 'Error during order delete!',
                ],
                400
            );
        }

        return response()->json(
            [
            'success' => true,
            'message' => 'Successfully delete!',
            ]
        );
    }
}
