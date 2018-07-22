<?php

namespace Shippinno\Labs\Infrastructure\Persistence\Doctrine\Type\ValueObject;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Tanigami\ValueObjects\Web\Url;

class UrlType extends StringType
{
    /**
     * @param Url $value
     * @param AbstractPlatform $platform
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return parent::convertToDatabaseValue($value->url(), $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $phpValue = parent::convertToPHPValue($value, $platform);
        return is_null($phpValue) ? null : new Url($phpValue);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'url';
    }
}