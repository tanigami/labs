<?php

namespace Shippinno\Labs\Tests\Unit\Infrastructure\Domain\Model\Lab;

use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\PDOSqlite\Driver;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\TestCase;
use Shippinno\Labs\Domain\Model\Lab\Attendee;
use Shippinno\Labs\Domain\Model\Lab\Lab;
use Shippinno\Labs\Domain\Model\Lab\LabId;
use Shippinno\Labs\Domain\Model\Lab\Member;
use Shippinno\Labs\Domain\Model\Lab\Session;
use Shippinno\Labs\Domain\Model\Lab\SessionId;
use Shippinno\Labs\Domain\Model\User\UserBuilder;
use Shippinno\Labs\Infrastructure\Domain\Model\Lab\DoctrineLabRepository;
use Shippinno\Labs\Tests\Unit\Application\Command\Lab\LabBuilder;
use Shippinno\Labs\Infrastructure\Persistence\Doctrine\EntityManagerFactory;
use Tanigami\ValueObjects\Time\TimeRange;

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

    public function testFullLabAggregateIsAddedAndRemoved()
    {
        $lab = LabBuilder::lab()->build();
        $member = UserBuilder::user()->build();
        $lab->addMember($member, new DateTimeImmutable('2018-01-01 00:00:00'));
        $sessionId = new SessionId;
        $lab->addSession(
            $sessionId,
            'title',
            new TimeRange(
                new DateTimeImmutable('2019-01-01 00:00:00'),
                new DateTimeImmutable('2019-01-01 01:00:00')
            ),
            'description'
        );
        $lab->addSessionAttendee($sessionId, $member);
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
            $entityManager->getClassMetadata(Member::class),
            $entityManager->getClassMetadata(Session::class),
            $entityManager->getClassMetadata(Attendee::class),
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