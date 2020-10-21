<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RealState;
use App\Repository\RealStateRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RealStateSearchController extends Controller
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
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $repository = new RealStateRepository($this->realState);

        if($request->has('conditions')) {
            $repository->selectConditions($request->get('conditions'));
        }

        if($request->has('fields')){
            $repository->selectFilter($request->get('fields'));
        }

        return response()->json([
            "data" => $repository->getResult()->paginate(10),
        ], 200);
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show(int $id)
    {
        //
    }
}
