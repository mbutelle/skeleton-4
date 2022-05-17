<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Graph\Query;

use Laudis\Neo4j\Databags\Statement;

final class QueryBuilder
{
    public const DEFAULT_ALIAS = 'm';

    public const CLAUSE_AND = 'AND';
    public const CLAUSE_OR = 'OR';

    private GraphQuery $query;

    public function __construct()
    {
        $this->query = new GraphQuery();
    }

    public function create(string $identifier, string $label, array $properties): self
    {
        $this->query->statement = new Statement(
            sprintf('CREATE (%s:%s %s)',
                $identifier,
                $label,
                $this->stringifyProperties($properties)
            ),
            $properties
        );

        return $this;
    }

    public function match(string $match, array $parameters, string $clauseType = self::CLAUSE_AND, string $alias = self::DEFAULT_ALIAS): self
    {
        $this->query->query = sprintf('MATCH (%1$s:%2$s) WHERE %3$s RETURN %1$s',
            $alias,
            $match,
            $this->stringifyWhereParameters($parameters, $clauseType, $alias)
        );

        return $this;
    }

    public function build(): GraphQuery
    {
        return $this->query;
    }

    private function stringifyWhereParameters(array $parameters, string $clauseType, string $alias): string
    {
        $whereClause = '';
        $i = 0;
        foreach ($parameters as $parameter => $value) {
            $whereClause .= sprintf("%s%s.%s = '%s'",
                0 < $i++ ? sprintf(' %s ', $clauseType) : '',
                $alias,
                $parameter,
                $value
            );
        }

        return $whereClause;
    }

    private function stringifyProperties(array $properties): string
    {
        $stringifyProperties = '{';
        $i = 0;
        foreach ($properties as $property => $value) {
            $stringifyProperties .= sprintf('%s%2$s:$%2$s',
                0 < $i++ ? ',' : '',
                $property
            );
        }
        $stringifyProperties .= '}';

        return $stringifyProperties;
    }
}