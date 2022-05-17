<?php

namespace App\Shared\Infrastructure\Mongo;

final class MongoFilter
{
    public const FIND_OPTIONS = [
        'typeMap' => [
            'array' => 'array',
            'document' => 'array',
            'root' => 'array',
        ]
    ];

    public const AGGREGATE_OPTIONS = [
        'typeMap' => [
            'array' => 'array',
            'document' => 'array',
            'root' => 'array',
        ],
        'allowDiskUse' => true,
    ];

    private array $filters = [];

    private array $pipeline = [];

    /**
     * @param string $filter
     * @param mixed  $value
     *
     * @return $this
     */
    public function filter(string $filter, $value): self
    {
        $this->filters[$filter] = $value;

        return $this;
    }

    public function inFilter(string $filter, array $values = null): self
    {
        if (empty($values)) {
            return $this;
        }

        $this->filters[$filter] = $this->in($values);

        return $this;
    }

    public function orX(array $values): self
    {
        foreach ($values as $row) {
            $this->filters['$or'][] = $row;
        }

        return $this;
    }

    private function in(array $values): array
    {
        return ['$in' => array_values(array_unique($values))];
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function hasFilter(string $filter): bool
    {
        return isset($this->filters[$filter]);
    }

    public function addGroup(array $group): self
    {
        $this->pipeline[] = ['$group' => $group];

        return $this;
    }

    public function addSort(array $sort): self
    {
        $this->pipeline[] = ['$sort' => $sort];

        return $this;
    }

    public function getAggregateQuery(): array
    {
        $query = [];

        if (0 < \count($this->filters)) {
            $query[] = $this->getMatch();
        }

        foreach ($this->pipeline as $pipe) {
            $query[] = $pipe;
        }

        return $query;
    }

    public function getMatch(): array
    {
        return ['$match' => $this->getFilters()];
    }
}
