<?php

namespace App\DTO;

class ActivityListDTO
{
    /**
     * @var array
     */
    public $columns;

    /**
     * @var array
     */
    public $activities;

    public function __construct(array $columns = [], array $activities = [])
    {
        $this->columns = $columns;
        $this->activities = $activities;
    }

    public static function create(array $data): ActivityListDTO
    {
        $activityDTOs = [];
        $columns = array_keys($data[0]);

        foreach ($data as $row) {
            $activityDTOs[] = ActivityDTO::create($row);
        }

        return new ActivityListDTO($columns, $activityDTOs);
    }

    /**
     * @return array
     */
    public function getActivities(): array
    {
        return $this->activities;
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }
}