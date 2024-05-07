<?php declare(strict_types=1);

namespace App\GraphQL\Queries\Users;

use App\Models\User;

final readonly class UserRecentAdded
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        // TODO implement the resolver
        return User::orderBy('created_at', 'DESC')->limit(2)->get();
    }
}
