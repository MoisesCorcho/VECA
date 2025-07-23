<?php

namespace App\Exceptions;

use Exception;

class VisitStatusValidationException extends Exception
{
    public function __construct()
    {
        parent::__construct("A visit marked as 'Visited' requires a completed survey. To ensure data integrity and proper workflow, please revert the visit status to 'Scheduled' and complete the corresponding survey, the visit status will be updated automatically.");
    }
}
