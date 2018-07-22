<?php

namespace Shippinno\Labs\Application\Query;

use Verraes\ClassFunctions\ClassFunctions;

class QueryBus
{
    /**
     * @var QueryHandler[]
     */
    private $queryHandlers = [];

    /**
     * @param Query $query
     * @return mixed
     */
    public function handle(Query $query)
    {
        $underscoredQueryClass = ClassFunctions::underscore($query);

//        if (!isset($this->queryHandlers[$anUnderscoredQueryClass])) {
//            throw new HandlerNotFoundException(get_class($aQuery));
//        }

        $queryHandler = $this->queryHandlers[$underscoredQueryClass];

        return $queryHandler->handle($query);
    }

    /**
     * @param QueryHandler $queryHandler
     */
    public function register(QueryHandler $queryHandler): void
    {
        $underscoredQueryHandlerClass = ClassFunctions::underscore($queryHandler);
        $queryClass = str_replace(
            [
                '.handler',
                '_handler'
            ],
            [
                '',
                ''
            ],
            $underscoredQueryHandlerClass
        );

        $this->queryHandlers[$queryClass] = $queryHandler;
    }
}