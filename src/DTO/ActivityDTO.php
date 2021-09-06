<?php

namespace App\DTO;

class ActivityDTO
{
    public function __construct(array $row)
    {
        foreach ($row as $column => $value) {
            $this->$column = $value;
        }
    }

    public static function create(array $row): ActivityDTO
    {
        return new ActivityDTO($row);
    }
}