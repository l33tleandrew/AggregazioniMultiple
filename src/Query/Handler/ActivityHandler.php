<?php

namespace App\Query\Handler;

use App\Query\AbstractActivityHandler;
use App\Query\ActivityQuery;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ActivityHandler extends AbstractActivityHandler implements MessageHandlerInterface
{
    public function __invoke(ActivityQuery $query)
    {
        $aggregations = $query->getAggregations();
        $aggregations = $this->validate($aggregations);

        if (empty($aggregations)) {
            $activities = $this->repository->findAll();
        } else {
            $activities = $this->repository->findAllByAggregations($query->getAggregations());
        }

        return $activities;
    }

    public function validate(array $aggregations = []): array
    {
        $validAggregations = ['project', 'employee', 'date'];

        if (empty($aggregations)) {
            return [];
        }

        return array_intersect($validAggregations, $aggregations);
    }
}