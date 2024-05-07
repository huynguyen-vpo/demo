<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\ClientRepository;

class AuthController extends Controller
{
    //
    public function grantOauth2Token($clientSecret, $clientId, User $user)
    {
        $request = Request::create('oauth/token', 'POST', [
            'grant_type' => 'password',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'username' => $user->email,
            'password' => $user->password,
            'scope' => '',
        ], [], [], [
            'HTTP_Accept' => 'application/json'
        ]);
        $response = app()->handle($request);
        $decodedResponse = json_decode($response->getContent(), true);
        if($response->getStatusCode() != 200){
            return response()->json(['errors'=> 'Auth failed!!']);
        }

        return response()->json($decodedResponse);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required",
            "password" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json([
                "error" => $validator->errors()->first(),
            ], 400);
        }
        $user = User::where("email", $request->email)->first()->makeVisible(['role']);
        logger($user);
        if (!empty($user)) {
            if (Hash::check($request->password, $user->password)) {
                $user->password = $request->password;
                $clientRepository = app(ClientRepository::class);

                $clients = $clientRepository->forUser($user->id);
                logger($user);
                if (! empty($clients) || ! $clients) {
                    $client = $clientRepository->create($user->id, 'client', '', 'users', false, true);
                    return self::grantOauth2Token($client->secret, $client->id, $user);
                }
                return self::grantOauth2Token($clients[0]->secret, $clients[0]->id, $user);
            } else {
                return response()->json([
                    "error" => 'Password not matched',
                ], 404);
            }
        } else {
            return response()->json([
                "error" => 'Not found',
            ], 404);
        }
    }
}
