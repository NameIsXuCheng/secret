<?php

namespace App\Http\Controllers;

use App\Models\Secret;
use Illuminate\Http\Request;

use App\Http\Requests\RegisterAuthRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiController extends Controller
{
    //
    public $loginAfterSignUp = true;

    public function register(RegisterAuthRequest $request)
    {
//        $user = new Secret();
//        $user->app_key = $request->app_key;
//        $user->app_secret = $request->app_secret;
//        $user->save();
//
//        if ($this->loginAfterSignUp) {
//            return $this->login($request);
//        }

        return response()->json([
            'success' => false,
            'data' => '该接口已经废弃'
        ], 401);
    }

    public function login(Request $request)
    {
        $input = $request->only('app_key', 'app_secret');
        $jwt_token = null;

        $secret = Secret::where(['app_key'=>$input['app_key'],'app_secret'=>$input['app_secret']])->first();
        // 获取token
        if (!$jwt_token = JWTAuth::fromUser($secret)) {
            return response()->json([
                'success' => false,
                'message' => '错误的秘钥参数',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'token' => $jwt_token,
        ]);
    }

    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], 500);
        }
    }

    public function getAuthUser(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        $user = JWTAuth::authenticate($request->token);

        return response()->json(['user' => $user]);
    }

}
