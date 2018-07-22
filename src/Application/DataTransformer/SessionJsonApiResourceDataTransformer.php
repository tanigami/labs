<?php

namespace Shippinno\Labs\Application\DataTransformer;

use Shippinno\Learn\Application\JsonApi\Serializer\SessionSerializer;
use Shippinno\Labs\Domain\Model\Lab\Session;
use Tobscure\JsonApi\Resource;

class SessionJsonApiResourceDataTransformer implements SessionDataTransformer
{
    /**
     * @var Session
     */
    private $session;

    /**
     * {@inheritdoc}
     */
    public function write(Session $session): void
    {
        $this->session = $session;
    }

    /**
     * @return Resource
     */
    public function read(): Resource
    {
        return new Resource($this->session, new SessionSerializer);
    }
}
