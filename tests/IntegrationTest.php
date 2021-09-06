<?php

namespace App\Tests;

use App\DTO\ActivityDTO;
use App\DTO\ActivityListDTO;
use App\Repository\ActivityRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class IntegrationTest extends KernelTestCase
{
    /**
     * @var ActivityRepositoryInterface
     */
    private $activityRepository;

    public function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->activityRepository = $kernel->getContainer()->get(ActivityRepositoryInterface::class);
    }

    public function testFindAll()
    {
        $activityList = $this->activityRepository->findAll();
        $this->assertInstanceOf(ActivityListDTO::class, $activityList);

        /** @var ActivityDTO $activity */
        foreach ($activityList->getActivities() as $activity) {
            $this->assertObjectHasAttribute('project', $activity);
            $this->assertObjectHasAttribute('employee', $activity);
            $this->assertObjectHasAttribute('date', $activity);
            $this->assertObjectHasAttribute('hours', $activity);
        }
    }

    public function testFindAllByAggregationsUsingProjectAggregation()
    {
        $activityList = $this->activityRepository->findAllByAggregations(['project']);
        $this->assertInstanceOf(ActivityListDTO::class, $activityList);

        /** @var ActivityDTO $activity */
        foreach ($activityList->getActivities() as $activity) {
            $this->assertObjectHasAttribute('project', $activity);
            $this->assertObjectHasAttribute('hours', $activity);
            $this->assertObjectNotHasAttribute('employee', $activity);
            $this->assertObjectNotHasAttribute('date', $activity);
        }
    }

    public function testFindAllByAggregationsUsingEmployeeAggregation()
    {
        $activityList = $this->activityRepository->findAllByAggregations(['employee']);
        $this->assertInstanceOf(ActivityListDTO::class, $activityList);

        /** @var ActivityDTO $activity */
        foreach ($activityList->getActivities() as $activity) {
            $this->assertObjectHasAttribute('employee', $activity);
            $this->assertObjectHasAttribute('hours', $activity);
            $this->assertObjectNotHasAttribute('project', $activity);
            $this->assertObjectNotHasAttribute('date', $activity);
        }
    }


    public function testFindAllByAggregationsUsingDateAggregation()
    {
        $activityList = $this->activityRepository->findAllByAggregations(['date']);
        $this->assertInstanceOf(ActivityListDTO::class, $activityList);

        /** @var ActivityDTO $activity */
        foreach ($activityList->getActivities() as $activity) {
            $this->assertObjectHasAttribute('date', $activity);
            $this->assertObjectHasAttribute('hours', $activity);
            $this->assertObjectNotHasAttribute('project', $activity);
            $this->assertObjectNotHasAttribute('employee', $activity);
        }
    }

    public function testFindAllByAggregationsUsingEmployeeAndProjectAggregation()
    {
        $activityList = $this->activityRepository->findAllByAggregations(['employee','project']);
        $this->assertInstanceOf(ActivityListDTO::class, $activityList);

        /** @var ActivityDTO $activity */
        foreach ($activityList->getActivities() as $activity) {
            $this->assertObjectHasAttribute('employee', $activity);
            $this->assertObjectHasAttribute('project', $activity);
            $this->assertObjectHasAttribute('hours', $activity);
            $this->assertObjectNotHasAttribute('date', $activity);
        }
    }
}