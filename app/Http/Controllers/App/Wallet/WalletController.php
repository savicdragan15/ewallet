<?php

namespace App\Http\Controllers\App\Wallet;

use App\Http\Controllers\Controller;

/**
 * Class WalletController
 * @package App\Http\Controllers\App\Wallet
 */
class WalletController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('app.wallet.wallet');
    }
}
