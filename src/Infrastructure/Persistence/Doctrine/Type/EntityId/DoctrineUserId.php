<?php

namespace Shippinno\Labs\Infrastructure\Persistence\Doctrine\Type\EntityId;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Shippinno\Labs\Domain\Model\User\UserId;

class DoctrineUserId extends StringType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'user_id';
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->id();
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new UserId($value);
    }
}