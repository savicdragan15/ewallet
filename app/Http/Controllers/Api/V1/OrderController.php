<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Order\StoreOrder;
use App\Http\Requests\Wallet\StoreWallet;
use App\Http\Services\IpStack;
use App\Models\Order;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json([
            'orders' => Order::where('user_id', $request->header('user'))
                        ->with('wallet', 'market')
                        ->orderBy('created_at', 'DESC')
                        ->paginate(15),
            'currency' => env('CURRENCY')
        ]);
    }

    /**
     * @param StoreOrder $request
     * @return JsonResponse
     */
    public function store(StoreOrder $request)
    {

        try {
            $ipStack = new IpStack();
            $location = $ipStack->callApi();

            $order = Order::create([
               'order_number' => 'rand',
               'wallet_id' => $request->input('wallet_id'),
               'user_id' => $request->input('user_id'),
               'market_id' => $request->input('market_id'),
               'amount' => $request->input('amount'),
               'latitude' => $location->latitude,
               'longitude' => $location->longitude,
               'flag' => $location->location->country_flag,
               'location' => json_encode($location),
            ]);

            $order->order_number = $order->id . '-' . Carbon::now()->format('d-m-Y');
            $order->save();

        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error during adding new order' . $e->getMessage(),
            ], 400);

        }

        return response()->json([
            'success' =>  true,
            'message' => 'Successfully added new order',
            'data'    =>  $order
        ]);

    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        return response()->json(Wallet::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try {

            $wallet = Wallet::findOrFail($id);
            $wallet->delete();

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error during wallet delete!',
            ], 400);

        }

        return response()->json([
            'success' => true,
            'message' => 'Successfully delete!',
        ]);
    }
}
