<?php

namespace Shippinno\Labs\Domain\Model\Common;

use Ramsey\Uuid\Uuid;

abstract class EntityId
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @param string|null $id
     */
    public function __construct(string $id = null)
    {
        $this->id = is_null($id) ? Uuid::uuid4()->toString() : $id;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @param self $other
     * @return bool
     */
    public function equals(self $other): bool
    {
        return $this->id() === $other->id();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id();
    }
}
