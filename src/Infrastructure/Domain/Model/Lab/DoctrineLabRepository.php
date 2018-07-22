<?php

namespace Shippinno\Labs\Infrastructure\Domain\Model\Lab;

use Doctrine\ORM\EntityRepository;
use Happyr\DoctrineSpecification\EntitySpecificationRepository;
use Happyr\DoctrineSpecification\Spec;
use Shippinno\Labs\Application\Query\CourseOrdering;
use Shippinno\Labs\Application\Query\Limiting;
use Shippinno\Labs\Domain\Model\Lab\Lab;
use Shippinno\Labs\Domain\Model\Lab\LabId;
use Shippinno\Labs\Domain\Model\Lab\LabRepository;
use Shippinno\Labs\Infrastructure\Persistence\Doctrine\Specification\LimitSpecification;
use Shippinno\Labs\Infrastructure\Persistence\Doctrine\Specification\OrderBySpecification;

class DoctrineLabRepository extends EntitySpecificationRepository implements LabRepository
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
    public function labOfId(LabId $labId): ?Lab
    {
        /** @var Lab|null $course */
        $course = $this->find($labId);

        return $course;
    }

    /**
     * @return Lab[]
     */
    public function satisfying($specification, CourseOrdering $ordering = null, Limiting $limiting = null): array
    {
        if (!is_null($ordering)) {
            switch ($ordering->orderBy()) {
                case CourseOrdering::ORDER_BY_NAME:
                    $field = 'name';
                    break;
            }
            $specification = $specification->and(new OrderBySpecification($field, $ordering->direction()));
        }

        if (!is_null($limiting)) {
            $specification = $specification->and(new LimitSpecification($limiting->limit()));
        }

        return $this->match($specification);
    }

    /**
     * {@inheritdoc}
     */
    public function countSatisfying($specification): int
    {
        $specification = Spec::countOf($specification);

        return $this->satisfying($specification)[0][1];
    }

    /**
     * {@inheritdoc}
     * @throws \Doctrine\ORM\ORMException
     */
    public function add(Lab $lab): void
    {
        $this->getEntityManager()->persist($lab);
    }

    /**
     * {@inheritdoc}
     */
    public function remove(Lab $lab): void
    {
        $this->getEntityManager()->remove($lab);
    }
}