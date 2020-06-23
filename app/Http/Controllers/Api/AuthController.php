<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Mail\NewUser;
use App\models\cart\CartTable;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        // return $request->all();
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            // 'activation_token' => str_random(60)
        ]);
        $user->save();
        // $user = User::first();
        Mail::to($request['email'])->send(new NewUser($user));
        // $user->notify(new SignupActivate($user));

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    /**
     * Login user and create token
     * To login you will provide you email and password.
     * You will get a response with this JSON     *
     * {
    "accessToken": "access_token",
    "token": {
        "id": "id",
        "user_id": 1,
        "client_id": 1,
        "name": "Personal Access Token",
        "scopes": [],
        "revoked": false,
        "created_at": "2020-03-13 09:28:24",
        "updated_at": "2020-03-13 09:28:24",
        "expires_at": "2021-03-13 09:28:24"
    }
    }
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        // return $request->all();
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            // 'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        // return ($credentials);
        $credentials['deleted_at'] = null;
        if (!Auth::attempt($credentials))
        // if (!Auth::attempt($credentials))
            return response()->json([
            'message' => 'Unauthorized'
        ], 401);
        $user = Auth::user();
        // return $user;
        // $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        // return $tokenResult;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        $cart_session = $this->cart_session($request->cookie_id, $user->id);
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
            'cart_session' => $cart_session,
            'status' => 200
        ]);
    }


    public function cart_session($cookie_id, $user_id)
    {
        $cart = CartTable::find($cookie_id);
        $cart->id = $user_id;
        $cart->save();
        return $cart;
    }


    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        // return ($request->all());
        //  $user = User::first();
        $user = auth('api')->user();
        // $user = response()->json($request->user());
//        $user->image = 'http://192.168.43.81:82/profile/jim_profile.jpeg';
        return $user = response()->json($user);
    }

    public function signupActivate($token)
    {
        $user = User::where('activation_token', $token)->first();
        if (!$user) {
            return response()->json([
                'message' => 'This activation token is invalid.'
            ], 404);
        }
        $user->active = true;
        $user->activation_token = '';
        $user->save();
        return redirect('login');
        // return $user;
    }
}
