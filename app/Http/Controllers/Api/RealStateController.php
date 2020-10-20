<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\RealStateRequest;
use App\Models\RealState;
use exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RealStateController extends Controller
{
    /**
     * @var RealState
     */
    private $realState;

    public function __construct(RealState $realState)
    {
        $this->realState = $realState;
    }

    /**
     * Display a listing of the Real States.
     * @return JsonResponse
     */
    public function index()
    {
        $realStates = $this->realState->with('images')->paginate();
        return response()->json($realStates, 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param RealStateRequest $request
     * @return JsonResponse
     */
    public function store(RealStateRequest $request)
    {
        $data = $request->all();
        $images = $request->file('images');

        try {
            $realState = $this->realState->create($data);

            if (isset($data['categories']) && count($data['categories'])) {
                $realState->categories()->sync($data['categories']);
            }

            if($images) {
                $imagesUploaded = [];

                foreach ($images as $image) {
                    $imagePath = $image->store('images', 'public');
                    $imagesUploaded[] = ["photo"=>$imagePath, "is_thumb"=>false];
                }

                $realState->images()->createMany($imagesUploaded);
            }

            return response()->json([
                "message" => "Imóvel cadastrado com sucesso",
                "data"    => $realState
            ], 200);
        } catch (exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            $realState = $this->realState->with('images')->findOrFail($id);

            return response()->json([
                "data" => $realState
            ], 200);
        } catch (exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 400);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update(int $id, Request $request)
    {
        $data = $request->all();
        $images = $request->file('images');

        try {
            $realState = $this->realState->findOrFail($id);
            $realState->update($data);

            if (isset($data['categories']) && count($data['categories'])) {
                $realState->categories()->sync($data['categories']);
            }

            if($images) {
                $imagesUploaded = [];

                foreach ($images as $image) {
                    $imagePath = $image->store('images', 'public');
                    $imagesUploaded[] = ["photo"=>$imagePath, "is_thumb"=>false];
                }

                $realState->images()->createMany($imagesUploaded);
            }

            return response()->json([
                "message" => "Imóvel atualizado com sucesso",
                "data"    => $realState
            ], 200);
        } catch (exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try {
            $realState = $this->realState->findOrFail($id);
            $realState->delete();

            return response()->json([
                "message" => "Imóvel excluído com sucesso",
            ], 200);
        } catch (exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 400);
        }
    }
}
