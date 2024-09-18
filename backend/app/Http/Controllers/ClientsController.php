<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\String_;

class ClientsController extends Controller
{
    // Lists all clients
    public function index()
    {
        $clients = Client::all();
        $clients = ClientResource::collection($clients);
        return response()->json(['status' => true, 'data' => $clients], 200);
    }

    // Create Client
    public function store(ClientRequest $request)
    {
        Client::store($request);
        return response()->json(['status' => true, 'message' => 'Client created Successfully'], 200);;
    }

    // Show client details
    public function show($id)
    {
        $client = Client::find($id);
        $client = new ClientResource($client);
        return response()->json(['status' => true, 'data' => $client], 200);
    }

    // Update client details
    public function update(Request $request, String $id)
    {
        // Use the store method from the Client model
        Client::store($request, $id);
        return response()->json(['status' => true, 'message' => 'Client updated Successfully'], 200);
    }

    // Delete client
    public function destroy($id)
    {
        $client = Client::find($id);
        $client->delete();
        return response()->json(['message' => 'Client deleted successfully']);
    }
}
