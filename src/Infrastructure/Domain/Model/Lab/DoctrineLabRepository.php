<?php

namespace Shippinno\Labs\Infrastructure\Domain\Model\Lab;

use Doctrine\ORM\EntityRepository;
use Happyr\DoctrineSpecification\EntitySpecificationRepository;
use Happyr\DoctrineSpecification\Spec;
use Shippinno\Labs\Application\Query\LabOrdering;
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
    public function labOfId(LabId $labId): ?Lab
    {
        /** @var Lab|null $course */
        $course = $this->find($labId);

        return $course;
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

    /**
     * @return Lab[]
     */
    public function satisfying($specification, LabOrdering $ordering = null, Limiting $limiting = null): array
    {
        if (!is_null($ordering)) {
            switch ($ordering->orderBy()) {
                case LabOrdering::ORDER_BY_NAME:
                    $field = 'name';
                    break;
            }
            $specification = $specification->and(new OrderBySpecification($field, $ordering->direction()));
        }

        $labs = $this->match($specification);

        $labs = array_filter(
            $labs,
            function (Lab $lab) use ($specification) {
                return $specification->isSatisfiedBy($lab);
            }
        );

        if (!is_null($limiting)) {
            $labs = array_slice($labs, 0, $limiting->limit());
        }

        return $labs;
    }

    /**
     * {@inheritdoc}
     */
    public function countSatisfying($specification): int
    {
        $specification = Spec::countOf($specification);

        return $this->satisfying($specification)[0][1];
    }
}