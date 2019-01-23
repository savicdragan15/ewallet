<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Wallet\UpdateWallet;
use App\Models\Wallet;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Wallet\StoreWallet;

/**
 * Class WalletController
 * @package App\Http\Controllers\Api\V1
 */
class WalletController extends Controller
{
    /**
     * @param  Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json(
            [
            'wallets' => Wallet::where('user_id', $request->header('user'))
                                ->orderBy('name')->paginate(15),
            'currency' => env('CURRENCY')
            ]
        );
    }

    /**
     * @param  StoreWallet $request
     * @return JsonResponse
     */
    public function store(StoreWallet $request)
    {
        
        try {
            $data = $request->all();
            $wallet = Wallet::create($data);
        } catch (Exception $e) {
            Bugsnag::notifyException($e);
            return response()->json(
                [
                'success' => false,
                'message' => 'Error during adding new wallet' . $e->getMessage(),
                ],
                400
            );
        }

        return response()->json(
            [
            'success' =>  true,
            'message' => 'Successfully added new wallet',
            'data'    =>  $wallet
            ]
        );
    }

    /**
     * @param  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        return response()->json(Wallet::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateWallet $request
     * @param Wallet $wallet
     * @return Wallet
     */
    public function update(UpdateWallet $request, Wallet $wallet)
    {
        try {
            $wallet->update($request->all());
        } catch (\Exception $e) {
            Bugsnag::notifyException($e);
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Error during update wallet!',
                ],
                400
            );
        }

        return response()->json(
            [
                'success' => true,
                'message' => 'Wallet successfully save!'
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
            $wallet = Wallet::findOrFail($id);
            $wallet->delete();
        } catch (Exception $e) {
            return response()->json(
                [
                'success' => false,
                'message' => 'Error during wallet delete!',
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
