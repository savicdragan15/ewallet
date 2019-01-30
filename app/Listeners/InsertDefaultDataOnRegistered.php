<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Carbon\Carbon;
use DB;

class InsertDefaultDataOnRegistered
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param UserRegistered $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        DB::table('categories')->insert([
            [
                'name' => 'Uncategorized',
                'user_id' => $event->user->id,
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'name' => 'Hrana',
                'user_id' => $event->user->id,
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'name' => 'Računi',
                'user_id' => $event->user->id,
                'created_at' => Carbon::now()->toDateTimeString()
            ],
        ]);

        DB::table('wallets')->insert([
           [
               'name' => 'Novčanik',
               'user_id' => $event->user->id,
               'active' => 1,
               'created_at' => Carbon::now()->toDateTimeString()
           ]
        ]);
    }
}
