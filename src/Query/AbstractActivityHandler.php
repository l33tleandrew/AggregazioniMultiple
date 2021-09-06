<?php

namespace App\Query;

use App\Repository\ActivityRepositoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractActivityHandler
{
    /**
     * @var ActivityRepositoryInterface
     */
    protected $repository;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    public function __construct(ActivityRepositoryInterface $repository, ValidatorInterface $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}
