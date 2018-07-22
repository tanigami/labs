<?php

namespace Shippinno\Labs\Infrastructure\Persistence\Doctrine\Type\EntityId;

use Doctrine\DBAL\Platforms\AbstractPlatform;

class DoctrineLabId extends DoctrineEntityId
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'lab_id';
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        return parent::convertToPHPValue($value, $platform);
    }

    /**
     * {@inheritdoc}
     */
    protected function getNamespace(): string
    {
        return 'Shippinno\Learn\Domain\Model\Lab';
    }
}

