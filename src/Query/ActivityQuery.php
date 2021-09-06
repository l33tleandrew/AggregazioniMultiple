<?php

namespace App\Query;

class ActivityQuery
{
    /**
     * @var array
     */
    private $aggregations;

    public function __construct(array $aggregations = [])
    {
        $this->aggregations = $aggregations;
    }

    public function getAggregations(): array
    {
        return $this->aggregations;
    }
}
