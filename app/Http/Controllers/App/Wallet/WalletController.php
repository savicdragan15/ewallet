<?php

namespace App\Http\Controllers\App\Wallet;

use App\Http\Controllers\Controller;
use App\Models\WalletType;

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
