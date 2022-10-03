<?php

namespace App\Service;

use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * 
 */
class CrudValidationException extends \Exception
{
    /**
     * @var ConstraintViolationListInterface
     */
    private $errors;

    public function __construct(ConstraintViolationListInterface $errors)
    {
        $this->errors = $errors;
        parent::__construct();
    }

    public function getConstraintViolationErrors(): ConstraintViolationListInterface
    {
        return $this->errors;
    }
}