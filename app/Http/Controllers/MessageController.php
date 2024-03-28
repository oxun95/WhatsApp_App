<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
class MessageController extends Controller
{
    public function getData()
    {
        $data = Result::all(); // Retrieve all records from the database using the model

        return response()->json($data); // Return the fetched data as JSON response
    }
}
