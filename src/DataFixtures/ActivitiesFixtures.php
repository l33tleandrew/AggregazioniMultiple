<?php

namespace App\DataFixtures;

use App\Entity\Activity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ActivitiesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $activitiesFilePath = __DIR__ . '/Resources/activities.json';
        $activitiesData = json_decode(file_get_contents($activitiesFilePath), true);

        foreach ($activitiesData as $activityData) {
            $activity = new Activity();
            $activity->setEmployee($this->getReference('employee_'.$activityData['employee']));
            $activity->setProject($this->getReference('project_'.$activityData['project']));
            $activity->setDate(new \DateTime($activityData['date']));
            $activity->setHours($activityData['hours']);

            $manager->persist($activity);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [EmployeeFixtures::class, ProjectFixtures::class];
    }
}
