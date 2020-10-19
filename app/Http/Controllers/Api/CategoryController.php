<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use \exception;

class CategoryController extends Controller
{
    /**
     * @var Category
     */
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = $this->category->all();
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CategoryRequest  $request
     * @return JsonResponse
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->all();

        try{
            $newCategory = $this->category->create($data);
            return response()->json([
                "message" => "Category created",
                "data" => $newCategory
            ], 200);
        } catch (exception $e) {
            return response()->json($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        try {
            $category = $this->category->findOrFail($id);
            return response()->json($category,200);
        } catch (exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 400);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  CategoryRequest  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(CategoryRequest $request, int $id)
    {
        $data = $request->all();

        try {
            $category = $this->category->findOrFail($id);
            $category->update($data);

            return response()->json([
                "message" => "Category updated!",
                "data" => $category
            ], 200);
        } catch (exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 400);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        try {
            $category = $this->category->findOrFail($id);
            $category->delete();

            return response()->json(["message" => "Category deleted"], 200);
        } catch (exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 400);
        }
    }

    public function realStates($id)
    {
        try {
            $category = $this->category->findOrFail($id);

            return response()->json([
                "data" => $category->realStates
            ], 200);
        } catch (exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 400);
        }
    }
}
