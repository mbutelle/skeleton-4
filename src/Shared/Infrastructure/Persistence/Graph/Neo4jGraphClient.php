<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Graph;

use App\Shared\Infrastructure\Persistence\Graph\Query\GraphQuery;
use Laudis\Neo4j\ClientBuilder;
use Laudis\Neo4j\Contracts\ClientInterface;

class Neo4jGraphClient implements Client
{
    private ClientInterface $client;

    public function __construct(string $neo4jGraphHost, string $neo4jGraphBolt)
    {
        $this->client = ClientBuilder::create()
            ->addHttpConnection('default', $neo4jGraphHost)
            ->addBoltConnection('bolt', $neo4jGraphBolt)
            ->setDefaultConnection('default')
            ->build()
        ;
    }

    public function run(GraphQuery $query)
    {
        return $this->client->run($query->query);
    }

    public function runStatement(GraphQuery $query)
    {
        return $this->client->runStatement($query->statement);
    }
}