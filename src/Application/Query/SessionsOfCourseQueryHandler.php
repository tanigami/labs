<?php

namespace Shippinno\Labs\Application\Query;

use Doctrine\ORM\EntityManager;
use Happyr\DoctrineSpecification\Query\OrderBy;
use Shippinno\Labs\Application\DataTransformer\SessionDataTransformer;
use Shippinno\Labs\Application\DataTransformer\SessionDtoDataTransformer;
use Shippinno\Labs\Domain\Model\Common\AnyOfSpecification;
use Shippinno\Labs\Domain\Model\Common\Limiting;
use Shippinno\Labs\Domain\Model\Lab\LabId;
use Shippinno\Labs\Domain\Model\Lab\Session;
use Shippinno\Labs\Domain\Model\Lab\SessionBelongsToCourseSpecification;
use Shippinno\Labs\Domain\Model\Lab\SessionOrdering;
use Shippinno\Labs\Domain\Model\Lab\SessionRepository;
use Shippinno\Labs\Domain\Model\Lab\SessionSpecificationFactory;

class SessionsOfCourseQueryHandler implements QueryHandler
{
    /**
     * @var SessionSpecificationFactory
     */
    private $sessionSpecificationFactory;

    /**
     * @var SessionRepository
     */
    private $sessionRepository;

    /**
     * @var SessionDataTransformer
     */
    private $sessionDataTransformer;
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param SessionRepository $sessionRepository
     * @param SessionDataTransformer $sessionDataTransformer
     */
    public function __construct(
        SessionSpecificationFactory $sessionSpecificationFactory,
        SessionRepository $sessionRepository,
        SessionDataTransformer $sessionDataTransformer,
        EntityManager $entityManager
    ) {
        $this->sessionSpecificationFactory = $sessionSpecificationFactory;
        $this->sessionRepository = $sessionRepository;
        $this->sessionDataTransformer = $sessionDataTransformer;
        $this->entityManager = $entityManager;
    }

    /**
     * @param SessionsOfCourseQuery $query
     * @return mixed
     */
    public function handle($query, SessionDataTransformer $sessionDataTransformer = null)
    {
        $specifications = $this->belongsToCourse(new LabId($query->courseId()));
        $specifications->and($this->displayable());

        $sessions = $this->sessionRepository->satisfying(
            $specifications,
            $query->ordering(),
            $query->limiting()
        );

        if (is_null($sessionDataTransformer)) {
            $sessionDataTransformer = new SessionDtoDataTransformer;
        }

        return array_map(function (Session $session) use ($sessionDataTransformer) {
            $sessionDataTransformer->write($session);

            return $sessionDataTransformer->read();
        }, $sessions);
    }

    private function belongsToCourse(LabId $courseId)
    {
        return $this->sessionSpecificationFactory->sessionBelongsToCourse($courseId);
    }

    private function displayable()
    {
        return $this->sessionSpecificationFactory->sessionDisplayable();
    }
}