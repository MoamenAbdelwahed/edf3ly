<?php

namespace Application\Src\Exceptions;

/**
 * Class InvalidArgumentException
 * @package Application\Src\Exceptions
 */
class InvalidArgumentException extends \Exception
{
    public function getStatusCode()
    {
        return $this->getCode();
    }
}
