<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Graph\Query;

use Laudis\Neo4j\Databags\Statement;

final class GraphQuery
{
    public string $query;
    public Statement $statement;
}