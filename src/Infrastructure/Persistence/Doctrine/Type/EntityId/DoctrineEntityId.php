<?php

namespace Shippinno\Labs\Infrastructure\Persistence\Doctrine\Type\EntityId;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

abstract class DoctrineEntityId extends GuidType
{
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
        $className = $this->getNamespace() . '\\' . $this->snakeToCamel($this->getName());

        return new $className($value);
    }

    /**
     * @return string
     */
    abstract protected function getNamespace(): string;

    /**
     * @param string $snake
     * @return string
     */
    protected function snakeToCamel(string $snake): string
    {
        return str_replace('_', '', ucwords($snake, '_'));
    }
}
