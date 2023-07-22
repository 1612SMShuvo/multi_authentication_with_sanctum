<?php

namespace App\Http\Controllers\Affiliator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Affiliator;
use Illuminate\Support\Facades\Hash;
use DB;
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

    public function signUp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:affiliators',
            'phone' => 'required|unique:affiliators',
            'skype' => 'required|unique:affiliators',
            'website' => 'required|unique:affiliators',
            'promotional_method' => 'required',
            'address' => 'required',
            'division' => 'required',
            'password' => 'required',
            'country' => 'required',
        ]); 
        
        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors()
            ], 422);
        }
        try{
            DB::beginTransaction();
            $affiliator = new Affiliator;
            
            $affiliator->name = $request->name;
            $affiliator->email = $request->email;
            $affiliator->phone = $request->phone;
            $affiliator->skype = $request->skype;
            $affiliator->website = $request->website;
            $affiliator->promotional_method = $request->promotional_method;
            $affiliator->address = $request->address;
            $affiliator->division = $request->division;
            $affiliator->country = $request->country;
            $affiliator->password = Hash::make($request->password);
            $affiliator->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'Affiliator Added Successfully',
                'data' => ['user' => $affiliator],
                'error' => []
            ]);
        } catch (\Exception $th) {
            DB::rollBack();
            $error = \Log::error($th->getMessage());
            return response()->json([
                'success' => true,
                'code' => 422,
                'message' => 'Affiliator Cannot be Added',
                'data' => [],
                'error' => ['errors' => $error]
            ]);
        }
    }
}
