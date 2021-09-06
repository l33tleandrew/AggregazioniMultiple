<?php

namespace App\DataFixtures;

use App\Entity\Employee;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EmployeeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $activitiesFilePath = __DIR__ . '/Resources/employee.json';
        $employeesData = json_decode(file_get_contents($activitiesFilePath), true);

        foreach ($employeesData as $employeeData) {
            $employee = new Employee();
            $employee->setId($employeeData['id']);
            $employee->setName($employeeData['name']);

            $manager->persist($employee);

            $this->addReference('employee_'.$employeeData['id'], $employee);
        }

        $manager->flush();
    }
}
