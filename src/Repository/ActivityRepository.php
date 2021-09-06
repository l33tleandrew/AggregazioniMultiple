<?php

namespace App\Repository;

use App\DTO\ActivityListDTO;
use App\Entity\Activity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ActivityRepository extends ServiceEntityRepository implements ActivityRepositoryInterface
{
    private $dbroperties = [
        'project' => 'projects.name',
        'employee' => 'employes.name',
        'date' => 'activities.date',
        'hours' => 'activities.hours',
    ];

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Activity::class);
    }

    public function findAll(): ActivityListDTO
    {
        $selectClauses = [];
        $selectSql = "SELECT ";
        $fromSql = " FROM activities 
                INNER JOIN employes ON activities.employee_id = employes.id
                INNER JOIN projects ON activities.project_id = projects.id ";

        foreach ($this->dbroperties as $alias => $field) {
            $selectClauses[] = $field . ' AS ' . $alias;
        }

        $selectSql = $selectSql . implode(', ', $selectClauses);

        $query = $selectSql . $fromSql;

        $em = $this->getEntityManager();
        $stmt = $em->getConnection()->prepare($query);
        $stmt->executeQuery();
        $result = $stmt->fetchAll();

        return ActivityListDTO::create($result);
    }

    public function findAllByAggregations(array $aggregations): ActivityListDTO
    {
        $selectClauses = $groupByClauses = [];

        $selectSql = "SELECT ";
        $fromSql = " FROM activities 
                INNER JOIN employes ON activities.employee_id = employes.id
                INNER JOIN projects ON activities.project_id = projects.id ";
        $groupBySql = 'GROUP BY ';

        foreach ($aggregations as $aggregation) {
            $selectClauses[] = $this->dbroperties[$aggregation] . ' AS ' . $aggregation;
            $groupByClauses[] = $this->dbroperties[$aggregation];
        }

        $selectClauses[] = 'SUM(activities.hours) as hours';

        $selectSql = $selectSql . implode(', ', $selectClauses);
        $groupBySql = $groupBySql . implode(', ', $groupByClauses);

        $query = $selectSql . $fromSql . $groupBySql;

        $em = $this->getEntityManager();
        $stmt = $em->getConnection()->prepare($query);
        $stmt->executeQuery();
        $result = $stmt->fetchAll();

        return ActivityListDTO::create($result);
    }
}
