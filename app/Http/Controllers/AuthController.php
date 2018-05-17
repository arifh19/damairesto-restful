<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use JWTAuth;
use JWTAuthException;

class AuthController extends Controller
{
    public function __construct(){
       //$this->middleware('jwt.auth');
         $this->middleware('jwt.auth',
         ['except' => ['index']]);
    }

    public function index()
    {
        $users = User::all();
        foreach ($users as $user) {
            $user->view_user = [
                'href' => 'api/v1/hidangan/' . $user->id,
                'method' => 'GET'
            ];
        }
        $response = [
            'msg' => 'List User',
            'users' => $users
        ];

        return response()->json($response,200);
    }
    public function store(Request $request){

        $this->validate($request,[
            'name' => 'required',
            'username' => 'required',
            'password' => 'required|min:8',
            'status' => 'required',

        ]);

        $name = $request->input('name');
        $username = $request->input('username');
        $password = $request->input('password');
        $status = $request->input('status');

        $user = new User([
            'name' => $name,
            'username' => $username,
            'password' => bcrypt($password),
            'status' => $status,
        ]);

        $credentials = [
            'username' => $username,
            'password' => $password
        ];

        if($user->save()){

            $token = null;
            try {
                if (!$token = JWTAuth::attempt($credentials)) {
                    return response()->json([
                        'message' => 'Username or Password are incorrect',
                    ], 404);
                }
            } catch (JWTAuthException $e) {
                return response()->json([
                    'message' => 'failed_to_create_token',
                ],404);
            }

            $user->signin = [
                'href' => 'api/v1/user/signin',
                'method' => 'POST',
                'params' =>'username, password'
            ];
            $response = [
                'msg' => 'User Created',
                'user' => $user,
                'token' => $token
            ];
            return response()->json($response,201);
        }
        $reponse = [
            'msg' => 'An error occured'
        ];
        return response()->json($response,404);
    }

    public function signin(Request $request){

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required|min:8'
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        if ($user = User::where('username', $username)->first()){
            $credentials = [
                'username' => $username,
                'password' => $password
            ];
            $token = null;
            try {
                if (!$token = JWTAuth::attempt($credentials)) {
                    return response()->json([
                        'message' => 'Username or Password are incorrect',
                    ], 404);
                }
            } catch (JWTAuthException $e) {
                return response()->json([
                    'message' => 'failed_to_create_token',
                ],404);
            }
            $response = [
                'message' => 'User signin',
                'user' => $user,
                'token' => $token
            ];
            return response()->json($response, 201);
        }
        $response = [
            'message' => 'An error occurred'
        ];
        return response()->json($response, 404);
    }

}
