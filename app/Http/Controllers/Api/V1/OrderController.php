<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Wallet\StoreWallet;
use App\Models\Order;
use App\Models\Wallet;
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
     * @param StoreWallet $request
     * @return JsonResponse
     */
    public function store(StoreWallet $request)
    {

        try {
            $data = $request->all();
            $wallet = Wallet::create($data);

        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error during adding new wallet' . $e->getMessage(),
            ], 400);

        }

        return response()->json([
            'success' =>  true,
            'message' => 'Successfully added new wallet',
            'data'    =>  $wallet
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
