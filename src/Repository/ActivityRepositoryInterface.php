<?php

namespace App\Repository;

use App\DTO\ActivityListDTO;

interface ActivityRepositoryInterface
{
    public function findAll(): ActivityListDTO;
    public function findAllByAggregations(array $aggregations): ActivityListDTO;
}