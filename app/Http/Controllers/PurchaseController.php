<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseStoreRequest;
use App\Http\Requests\PurchaseUpdateRequest;
use App\Http\Resources\PurchaseResource;
use App\Models\Purchase;
use App\Services\PurchaseService;
use Exception;
use Illuminate\Http\Response;

class PurchaseController extends Controller
{
    private $service;

    public function __construct(PurchaseService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $purchases = Purchase::all();
        return response()->json(PurchaseResource::collection($purchases), Response::HTTP_OK);
    }

    public function store(PurchaseStoreRequest $request)
    {
        try{
            $data = $request->all();
            $purchase = $this->service->store($data);
            return response()->json(new PurchaseResource($purchase), Response::HTTP_CREATED);
        }catch(Exception $e){
            //TODO: Exception
            dd($e->getMessage());
        }
    }

    public function show(int $id)
    {
        $purchase = Purchase::findOrFail($id);
        return response()->json(new PurchaseResource($purchase), Response::HTTP_OK);
    }

    public function update(PurchaseUpdateRequest $request, string $id)
    {
        try{
            $data = $request->all();
            $purchase = Purchase::findOrFail($id);
            $purchase->update($data);
            return response()->json($purchase, Response::HTTP_OK);
        }catch(Exception $e){
            //TODO: Exception
            dd($e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        Purchase::destroy($id);
        return response()->json([], Response::HTTP_OK);
    }
}
