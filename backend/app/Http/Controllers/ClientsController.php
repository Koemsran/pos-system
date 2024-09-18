<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\String_;

class ClientsController extends Controller
{
    // Lists all clients
    public function index()
    {
        $clients = Client::all();
        return $clients;
    }

    // Create Client
    public function store(Request $request)
    {
        $client = Client::store($request);
        return $client;
    }

    // Show client details
    public function show($id)
    {
        $client = Client::find($id);
        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }
        return $client;
    }

    // Update client details
    public function update(Request $request, String $id)
    {
        // Use the store method from the Client model
        Client::store($request, $id);
        return response()->json(['status' => true, 'message' => 'Updated Successfully'], 200);
    }

    // Delete client
    public function destroy($id)
    {
        $client = Client::find($id);
        $client->delete();
        return response()->json(['message' => 'Client deleted successfully']);
    }
}
