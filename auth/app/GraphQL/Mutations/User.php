<?php

namespace App\GraphQL\Mutations;

use App\Models\User as ModelsUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

final class User
{
    public function update($_, array $args){
        logger($args);
        $user = ModelsUser::findOrFail($args["id"]);
        $user->update([
            'id' => $user->id,
            'name' => $args['name'] ?? $user->name,
            'email' => $args['email'] ?? $user->email,
            'role'=> $args['role'] ?? $user->role,
            'password' => $args['password'] ?? $user->password
        ]);

        return $user;
    }
    
}
class Response extends Model{
    protected $fillable = ['status', 'message', 'data'];
}