<?php

namespace Shippinno\Labs\Application\Query;

use Exception;

class MissingQueryHandlerException extends Exception
{
    /**
     * @var string
     */
    private $queryName;

    /**
     * @param string $queryName
     * @return static
     */
    public static function forCommand($queryName): MissingQueryHandlerException
    {
        $exception = new static('Missing handler for query: ' . $queryName);
        $exception->queryName = $queryName;

        return $exception;
    }

    /**
     * @return string
     */
    public function queryName(): string
    {
        return $this->queryName;
    }
}