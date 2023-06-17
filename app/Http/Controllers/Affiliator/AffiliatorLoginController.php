<?php

namespace App\Http\Controllers\Affiliator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AffiliatorLoginController extends Controller
{
    public function login(Request $request)
    {
        $input = $request->all();
        $validation = \Validator::make($input,[
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if($validation->fails()){
            return response()->json(['errors' => $validation->errors()], 422);
        }
        if(Auth::guard('affiliator')->attempt(['email' => $input['email'], 'password' => $input['password']])){
            $user = Auth::guard('affiliator')->user();
            $token =  $user->createToken('Affiliator', ['affiliator'])->plainTextToken;
            return response()->json(['user' => $user, 'token' => $token], 200);
        }
    }

    public function user_info()
    {
        $user = auth()->user();
        return response()->json(['user' => $user], 200);
    }
}
