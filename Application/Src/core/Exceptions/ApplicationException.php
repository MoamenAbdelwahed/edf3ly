<?php

namespace Application\Src\Exceptions;

/**
 * Class ApplicationException
 * @package Application\Src\Exceptions
 */
class ApplicationException extends \Exception
{
    public function getStatusCode()
    {
        return $this->getCode();
    }
}
