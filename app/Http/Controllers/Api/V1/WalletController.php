<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Wallet\StoreWallet;
use App\Models\Wallet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Wallet[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return response()->json([
            'wallets' => Wallet::where('user_id', Auth::user()->id)->with('wallet_type')->paginate(15),
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
            $data['user_id'] = Auth::user()->id;

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
