<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
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
