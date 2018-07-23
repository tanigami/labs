<?php

namespace Shippinno\Labs\Application\Query;

use Verraes\ClassFunctions\ClassFunctions;

class QueryBus
{
    /**
     * @var array
     */
    private $queryHandlers = [];

    /**
     * @param mixed $query
     * @return mixed
     * @throws MissingQueryHandlerException
     */
    public function handle($query)
    {
        $underscoredQueryClass = ClassFunctions::underscore($query);
        if (!isset($this->queryHandlers[$underscoredQueryClass])) {
            throw new MissingQueryHandlerException(get_class($query));
        }
        $queryHandler = $this->queryHandlers[$underscoredQueryClass];

        return $queryHandler->handle($query);
    }

    /**
     * @param mixed $queryHandler
     */
    public function register($queryHandler): void
    {
        $underscoredQueryHandlerClass = ClassFunctions::underscore($queryHandler);
        $queryClass = str_replace(['.handler', '_handler'], ['', ''], $underscoredQueryHandlerClass);
        $this->queryHandlers[$queryClass] = $queryHandler;
    }
}