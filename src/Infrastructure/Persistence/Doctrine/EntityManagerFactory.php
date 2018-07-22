<?php

namespace Shippinno\Learn\Infrastructure\Persistence\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Shippinno\Labs\Infrastructure\Persistence\Doctrine\Type\EntityId\DoctrineLabId;
use Shippinno\Labs\Infrastructure\Persistence\Doctrine\Type\EntityId\DoctrineSessionId;

class EntityManagerFactory
{
    /**
     * @param Connection $conn
     * @return EntityManager
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function build(Connection $conn): EntityManager
    {
        Type::addType('course_id', DoctrineLabId::class);
        Type::addType('session_id', DoctrineSessionId::class);

        return EntityManager::create(
            $conn,
            Setup::createXMLMetadataConfiguration([__DIR__ . '/Mapping'], true)
        );
    }
}
