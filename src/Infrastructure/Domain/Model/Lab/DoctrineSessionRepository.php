<?php

namespace Shippinno\Labs\Infrastructure\Domain\Model\Lab;

use Happyr\DoctrineSpecification\EntitySpecificationRepository;
use Shippinno\Labs\Application\Query\Limiting;
use Shippinno\Labs\Application\Query\Ordering;
use Shippinno\Labs\Application\Query\SessionOrdering;
use Shippinno\Labs\Domain\Model\Lab\LabId;
use Shippinno\Labs\Domain\Model\Lab\Session;
use Shippinno\Labs\Domain\Model\Lab\SessionId;
use Shippinno\Labs\Domain\Model\Lab\SessionRepository;
use Shippinno\Labs\Infrastructure\Persistence\Doctrine\Specification\LimitSpecification;
use Shippinno\Labs\Infrastructure\Persistence\Doctrine\Specification\OrderBySpecification;

class DoctrineSessionRepository extends EntitySpecificationRepository implements SessionRepository
{
    /**
     * {@inheritdoc}
     */
    public function all(): array
    {
        return $this->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function sessionOfId(SessionId $sessionId): ?Session
    {
        /** @var Session|null $session */
        $session = $this->find($sessionId);

        return $session;
    }

    /**
     * {@inheritdoc}
     */
    public function satisfying($specification, Ordering $ordering = null, Limiting $limiting = null): array
    {
        if (!is_null($ordering)) {
            switch ($ordering->orderBy()) {
                case SessionOrdering::ORDER_BY_START:
                    $field = 'hours.start';
                    break;
                case SessionOrdering::ORDER_BY_END:
                    $field = 'hours.end';
                    break;
            }
        }

        $specification = $specification->and(new OrderBySpecification($field, $ordering->direction()));

        if (!is_null($limiting)) {
            $specification = $specification->and(new LimitSpecification($limiting->limit()));
        }

        return $this->match($specification);
    }

    /**
     * {@inheritdoc}
     */
    public function sessionsOfCourseId(LabId $courseId): array
    {
        return $this->findBy(['courseId' => $courseId]);
    }

    /**
     * {@inheritdoc}
     * @throws \Doctrine\ORM\ORMException
     */
    public function add(Session $session): void
    {
        $this->getEntityManager()->persist($session);
    }
}