<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Category;
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
}
