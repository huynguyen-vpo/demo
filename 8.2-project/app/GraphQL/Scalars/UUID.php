<?php declare(strict_types=1);

namespace App\GraphQL\Scalars;

use GraphQL\Error\Error;
use GraphQL\Error\InvariantViolation;
use GraphQL\Language\AST\Node;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Utils\Utils;

/** Read more about scalars here: https://webonyx.github.io/graphql-php/type-definitions/scalars. */
final class UUID extends ScalarType
{
    /** Serializes an internal value to include in a response. */
    public function serialize(mixed $value): mixed
    {
        // TODO validate if $value might be incorrect
        if (!$this->validateUUID($value)) {
            throw new InvariantViolation("Could not serialize following value as UUID: " . Utils::printSafe($value));
        }

        // Assuming the internal representation of the value is always correct
        return $value;
    }

    /** Parses an externally provided value (query variable) to use as an input. */
    public function parseValue(mixed $value): mixed
    {
        // TODO implement validation and transformation of $value
        if (!$this->validateUUID($value)) {
            throw new InvariantViolation("Cannot represent following value as UUID: " . Utils::printSafe($value));
        }

        return $value;
    }

    /**
     * Parses an externally provided literal value (hardcoded in GraphQL query) to use as an input.
     *
     * Should throw an exception with a client friendly message on invalid value nodes, @see \GraphQL\Error\ClientAware.
     *
     * @param  \GraphQL\Language\AST\ValueNode&\GraphQL\Language\AST\Node  $valueNode
     * @param  array<string, mixed>|null  $variables
     */
    public function parseLiteral(Node $valueNode, ?array $variables = null): mixed
    {
        // TODO implement validation and transformation of $valueNode
        if (!$valueNode instanceof StringValueNode) {
            throw new Error('Query error: Can only parse strings got: ' . $valueNode->kind, [$valueNode]);
        }

        if (!$this->validateUUID($valueNode->value)) {
            throw new Error("Not a valid UUID", [$valueNode]);
        }

        return $valueNode->value;
    }
    private function validateUUID($value)
    {
        $pattern = "/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i";

        return preg_match($pattern, $value);
    }
}
