<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;

class ForumController extends Controller
{

    public function __construct()
    {
        auth()->shouldUse('api');
    }
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'title' => 'required|min:5',
            'body' => 'required|min:10',
            'category' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        try {
            $user = auth()->userOrFail();
        } catch (UserNotDefinedException $e) {
            return response()->json([
                'message' => 'not authenticated'
            ], 401);
        }
        $user->forums()->create([
            'title' => request('title'),
            'body' => request('body'),
            'slug' => Str::slug(request('slug')) . '-' . time(),
            'category' => request('category'),
        ]);

        return response()->json([
            'message' => 'Successfully posted'
        ], 201);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
