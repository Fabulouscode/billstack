<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::paginate();

        return $this->wrapJsonResponse(ClientResource::collection($clients)->response(), 'Client retrieved successfully');
    }

    public function store(ClientRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $client = Client::create($data);

        return $this->jsonResponse(HTTP_CREATED, 'Client created successfully', [
            'data' => new ClientResource($client),
        ]);
    }
}
