<?php
/**
 *
 */
namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Location\StoreLocation;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class LocationController
 *
 * @package App\Http\Controllers\Api\V1
 */

class LocationController extends Controller
{
    /**
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->hasHeader('all') && $request->header('all')) {
            return response()->json(
                ['locations' => Location::where('user_id', $request->header('user'))
                ->orderBy('name')->get()]
            );
        }

        return response()->json(
            ['locations' => Location::where('user_id', $request->header('user'))->orderBy('name')
            ->paginate(15)]
        );
    }

    /**
     * @param  StoreLocation $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreLocation $request)
    {
        try {
            $data = $request->all();
            $location = Location::create($data);
        } catch (\Exception $e) {
            return response()->json(
                [
                'success' => false,
                'message' => 'Error during adding new location' . $e->getMessage(),
                ],
                400
            );
        }

        return response()->json(
            [
            'success' =>  true,
            'message' => 'Successfully added new location',
            'data'    =>  $location
            ]
        );
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
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
