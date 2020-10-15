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
        $realState = $this->realState->paginate();
        return response()->json($realState, 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     * @param  \App\Models\RealState  $realState
     * @return \Illuminate\Http\Response
     */
    public function show(RealState $realState)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RealState  $realState
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RealState $realState)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param  \App\Models\RealState  $realState
     * @return \Illuminate\Http\Response
     */
    public function destroy(RealState $realState)
    {
        //
    }
}
