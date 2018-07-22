<?php

namespace Shippinno\Labs\Application\Query;

interface QueryHandler
{
    /**
     * @param Query $query
     * @return mixed
     */
    public function handle($query);
}