<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $validated = $request->validated();
        $category = Category::create([
            'name' => $validated['name']
        ]);
        if($category){
            $newrow ='<tr id="category-'.$category->id.'" class=" text-center odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                    <td class="px-6 py-4">
                        '.$category->id.'
                    </td>
                    <td class="px-6 py-4">
                        '.$category->name.'
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a data-id="'.$category->id.'" class="delete" id="delete" href="#"><span class="text-base text-red-500">X</span></a>
                    </td>
                </tr>';
            return response()->json(['newrow' => $newrow,'message'=> __("category stored")]);
        }else{
            return response()->json(['message' => $request->errors()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        if(!$category){
            return response()->json(['message'=> __("error message")]);
        }
        $category->tasks()->detach();
        $category->delete();

        return response()->json(['message'=> __("category deleted")]);
    }
}
