<?php

namespace App\Http\Controllers\Api\V1;

use App\User;
use App\Http\Requests\Profile\UpdateProfile;
use App\Http\Controllers\Controller;

/**
 * Class ProfileController
 * @package App\Http\Controllers\Api\V1
 */
class ProfileController extends Controller
{
    /**
     *
     */
    public function index()
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(['id' => $id], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateProfile $request
     * @param  int           $id
     * @return array
     */
    public function update(UpdateProfile $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $user->update($request->all());
        } catch (\Exception $e) {
            return response()->json(
                [
                'success' => false,
                'message' => 'Error during User profile save!',
                ],
                400
            );
        }

        return response()->json(
            [
            'success' => true,
            'message' => 'User profile successfully save!'
            ]
        );
    }
}
