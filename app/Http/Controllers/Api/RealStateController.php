<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RealState;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $realStates = $this->realState->paginate();
        return response()->json($realStates, 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();
        try {
            $realState = $this->realState->create($data);
            return response()->json([
                "message" => "Imóvel cadastrado com sucesso",
                "data" => $realState
            ], 200);
        } catch (\exception $e) {
            return response()->json(["error"=> $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     * @param  \App\Models\RealState  $realState
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $realState = $this->realState->findOrFail($id);

            return response()->json([
                "data" => $realState
            ], 200);
        } catch (\exception $e) {
            return response()->json(["error"=> $e->getMessage()], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RealState  $realState
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        $data = $request->all();
        try {
            $realState = $this->realState->findOrFail($id);
            $realState->update($data);
            return response()->json([
                "message" => "Imóvel atualizado com sucesso",
                "data"    => $realState
            ], 200);
        } catch (\exception $e) {
            return response()->json(["error"=> $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param  \App\Models\RealState  $realState
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $realState = $this->realState->findOrFail($id);
            $realState->delete();

            return response()->json([
                "message" => "Imóvel excluído com sucesso",
            ], 200);
        } catch (\exception $e) {
            return response()->json(["error"=> $e->getMessage()], 400);
        }
    }
}