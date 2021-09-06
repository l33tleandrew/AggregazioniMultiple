<?php

namespace App\DataFixtures;

use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProjectFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $activitiesFilePath = __DIR__ . '/Resources/project.json';
        $projectsData = json_decode(file_get_contents($activitiesFilePath), true);

        foreach ($projectsData as $projectData) {
            $project = new Project();
            $project->setId($projectData['id']);
            $project->setName($projectData['name']);

            $manager->persist($project);

            $this->addReference('project_'.$projectData['id'], $project);
        }

        $manager->flush();
    }
}
