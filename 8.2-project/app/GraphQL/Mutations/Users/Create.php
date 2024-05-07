<?php declare(strict_types=1);

namespace App\GraphQL\Mutations\Users;

use App\Models\User;
use Illuminate\Support\Str;

final readonly class Create
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        // TODO implement the resolver
        return User::create([
            "name"=> $args["name"],
            "email"=> $args["email"],
            "email_verified_at" => now(),
            "password"=> bcrypt($args["password"]),
            "remember_token" => Str::random(10),
        ]);
    }
}
