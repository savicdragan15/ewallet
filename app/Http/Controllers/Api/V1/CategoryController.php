<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Category;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        if ($request->hasHeader('all') && $request->header('all')) {
            return response()->json(
                ['categories' => Category::where('user_id', $request->header('user'))
                    ->orderBy('name')->get()]
            );
        }

        return response()->json(
            ['categories' => Category::where('user_id', $request->header('user'))->orderBy('name')
                ->paginate(15)]
        );
    }

    /**
     * @param Category $category
     * @return Category
     */
    public function show(Category $category)
    {
        return $category;
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
            $category = Category::findOrFail($id);
            $category->delete();
        } catch (Exception $e) {
            Bugsnag::notifyException($e);
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Error during order delete!',
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
