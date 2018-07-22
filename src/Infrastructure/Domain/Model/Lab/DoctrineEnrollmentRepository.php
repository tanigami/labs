<?php

namespace Shippinno\Labs\Infrastructure\Domain\Model\Lab;

use Happyr\DoctrineSpecification\EntitySpecificationRepository;
use Shippinno\Labs\Domain\Model\Lab\Enrollment;
use Shippinno\Labs\Domain\Model\Lab\EnrollmentRepository;

class DoctrineEnrollmentRepository extends EntitySpecificationRepository implements EnrollmentRepository
{
    /**
     * {@inheritdoc}
     */
    public function add(Enrollment $enrollment): void
    {
        $this->getEntityManager()->persist($enrollment);
    }

    /**
     * {@inheritdoc}
     */
    public function remove(Enrollment $enrollment): void
    {
        $this->getEntityManager()->remove($enrollment);
    }
}
