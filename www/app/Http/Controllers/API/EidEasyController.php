<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\EidEasyApiConsumer;
use App\Http\Requests\EidEasyApiFetchUser;

class EidEasyController extends Controller {

    protected $service;
 
    public function __construct()
    {
        $this->service = resolve(EidEasyApiConsumer::class);
    }

    public function verifyUser(Request $request) {

        if(!$request->filled('username')){
            return response()->json([
                'message' => 'username is required!'
            ], 422);
        }

        $username = trim($request->username);
        $searchParams = [
            'by'   => 'username',
            'value' => $username
        ];

        $returnResult = [];

        if($this->service->checkUserExist($searchParams)) {
            $returnResult = [
                'username' => $request->username,
                'token' => $this->service->generateToken($username),
            ];
        }
        
        return response()->json([
            $returnResult
        ], 200);
    }

    public function fetchUser(EidEasyApiFetchUser $request) {

        $username = trim($request->username);
        $token    = trim($request->token);

        if($this->service->decryptToken($token) !== $username){
            return response()->json([
                'error' => 'Unauthenticated.'
            ], 401);
        }

        return response()->json([
            'user' => $this->service->findUserBy([
                'by' => 'username',
                'value' => $username,
            ])
        ], 200);


    }

}