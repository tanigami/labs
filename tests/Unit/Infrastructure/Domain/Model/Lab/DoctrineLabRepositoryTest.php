<?php

namespace Shippinno\Labs\Tests\Unit\Infrastructure\Domain\Model\Lab;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\PDOSqlite\Driver;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\TestCase;
use Shippinno\Labs\Domain\Model\Lab\Lab;
use Shippinno\Labs\Domain\Model\Lab\LabId;
use Shippinno\Labs\Infrastructure\Domain\Model\Lab\DoctrineLabRepository;
use Shippinno\Labs\Tests\Unit\Application\Service\Lab\LabBuilder;
use Shippinno\Labs\Infrastructure\Persistence\Doctrine\EntityManagerFactory;

class DoctrineLabRepositoryTest extends TestCase
{
    /**
     * @var PrecociousDoctrineLabRepository
     */
    private $labRepository;

    public function setUp()
    {
        $this->labRepository = $this->createLabRepository();
    }

    public function testLabIsAddedAndRemoved()
    {
        $lab = LabBuilder::lab()->build();
        $this->labRepository->add($lab);
        $this->assertLabExists($lab->labId());
        $this->labRepository->remove($lab);
        $this->assertLabDoesNotExist($lab->labId());
    }

    private function assertLabExists(LabId $labId)
    {
        $this->assertInstanceOf(Lab::class, $this->labRepository->labOfId($labId));
    }

    private function assertLabDoesNotExist(LabId $labId)
    {
        $this->assertNull($this->labRepository->labOfId($labId));
    }

    private function createLabRepository()
    {
        $connection = new Connection(['url' => 'sqlite:///:memory:'], new Driver);
        $entityManager = (new EntityManagerFactory)->build($connection);
        $this->initSchema($entityManager);

        return new PrecociousDoctrineLabRepository($entityManager, $entityManager->getClassMetadata(Lab::class));
    }

    private function initSchema(EntityManager $entityManager)
    {
        $tool = new SchemaTool($entityManager);
        $tool->createSchema([
            $entityManager->getClassMetadata(Lab::class),
        ]);
    }
}

class PrecociousDoctrineLabRepository extends DoctrineLabRepository
{
    public function add(Lab $lab): void
    {
        parent::add($lab);
        $this->getEntityManager()->flush();
    }

    public function remove(Lab $lab): void
    {
        parent::remove($lab);
        $this->getEntityManager()->flush();
    }
}