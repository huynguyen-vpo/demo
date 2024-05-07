<?php declare(strict_types=1);

namespace App\GraphQL\Queries\Users;

use App\Models\User;

final readonly class UserByEmail
{
    /** @param  array{}  $args */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
        return User::where('email', $args['email'])->first();
    }
}
