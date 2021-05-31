<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\ErrorDescription as ErrDesc;

class AuthController extends Controller
{
    public function __construct(){
    	$this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $req){

    	$validator = Validator::make($req->all(), [
    		'email' => 'required|email',
    		'password' => 'required|string|min:6'
    	]);

    	if($validator->fails()){
    		return response()->json($validator->errors(), 400);
    	}

    	// $token_validity = 24 * 60;
        $token_validity = 0.5 * 60;

    	$this->guard()->factory()->setTTL($token_validity);

    	if (!$token = $this->guard()->attempt($validator->validated())) {

            $email = $req->email;
            $passwordFE = $req->passwordFE;

            $check = User::where('email', $email)->exists();

            if (!$check) {

                $err_code = '0003';
                $err_message = ErrDesc::getResponseDesc($err_code);

            }else{
                // do logic later
                $user = User::where('email', $email)
                    ->first();

                $passwordBE = $user->password;


                $verify_password = password_verify($passwordFE, $passwordBE);

                if (!$verify_password) {
                    // password matched
                    $err_code = '0002';
                    $err_message = ErrDesc::getResponseDesc($err_code);
                }
            }

    		return response()->json([
                'status' => false,
    			'err_code' => $err_code,
                'err_message' => $err_message
    		], 401);

    	}else{

            $err_code = '0000';
            $err_message = ErrDesc::getResponseDesc($err_code);

        }

        $data = [ 
            'status' => true,
            'err_code' => $err_code,
            'err_message' => $err_message,
            'data' => $this->responseWithToken($token)
        ];

        // $data = $this->responseWithToken($token);

    	// return $this->responseWithToken($token);
        return response()->json($data);
    }

    public function register(Request $req){
    	$validator = Validator::make($req->all(), [
    		'name' => 'required|string|between:2,100',
    		'email' => 'required|email|unique:users',
    		'password' => 'required|confirmed|min:6'
    	]);

    	if ($validator->fails()) {
    		return response()->json([
    			$validator->errors()
    		], 422);
    	}

    	$user = User::create(array_merge(
    		$validator->validated(),
    		['password' => bcrypt($req->password)]
    	));

    	return response()->json(['message' => 'User created successfully', 'user' => $user]);
    }

    public function logout(){

    	$this->guard()->logout();

    	return response()->json(['message' => 'User logged out successfully']);

    }

    public function profile(){

    	return response()->json($this->guard()->user());
    }

    public function refresh(){

    	return $this->responseWithToken($this->guard()->refresh());
    }

    protected function responseWithToken($token){
    	// return response()->json([
    	// 	'token' => $token,
    	// 	'token_type' => 'bearer',
    	// 	'token_validity' => $this->guard()->factory()->getTTL() * 60
    	// ]);

        $data = [ 
            'token' => $token,
            'token_type' => 'bearer',
            'token_validity' => $this->guard()->factory()->getTTL() * 60
        ];

        return $data;
    }

    protected function guard(){
    	return Auth::guard();
    }

}
