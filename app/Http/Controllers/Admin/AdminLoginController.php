<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Affiliator;
use Auth;

class AdminLoginController extends Controller
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
        if(Auth::guard('user')->attempt(['email' => $input['email'], 'password' => $input['password']])){
            $user = Auth::guard('user')->user();
            $token =  $user->createToken('Admin', ['user'])->plainTextToken;
            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'User Logged in Successfully',
                'data' => ['user' => $user, 'token' => $token],
                'error' => []
            ]);
        }else{
            return response()->json([
                'success' => false,
                'code' => 2001,
                'message' => 'User Doesnot Exist',
                'data' => [],
                'error' => ['The User information you gave is invalid', $request->all()]
            ]);
        }
    }

    public function user_info()
    {
        $user = auth()->user();
        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'User Info Retrived',
            'data' => ['user' => $user],
            'error' => []
        ]);
    }

    public function allAdminInfo()
    {
        $users = User::orderBy('created_at', 'desc')->sortable();

        if (request('email')) {

            $user->where('users.email', request('email'));
        }
        if( request('per_page') ){
            $result = $users->orderBy('id', 'desc')->paginate(request('per_page'));
        }else{
            $result = $users->orderBy('id', 'desc')->paginate(10);
        }
        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'Admin Infos Retrived',
            'data' => ['user' => $result],
            'error' => []
        ]);
    }

    public function allAffiliatorInfo()
    {
        $affiliators = Affiliator::orderBy('created_at', 'desc')->sortable();

        if (request('division')) 
        {
            $affiliators->where('affiliators.division', request('division'));
        }
        if( request('per_page') ){
            $result = $affiliators->orderBy('id', 'desc')->paginate(request('per_page'));
        }else{
            $result = $affiliators->orderBy('id', 'desc')->paginate(10);
        }
        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'Affiliator Infos Retrived',
            'data' => ['user' => $result],
            'error' => []
        ]);
    }
}
