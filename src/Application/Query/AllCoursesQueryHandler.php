<?php

namespace Shippinno\Labs\Application\Query;

use Closure;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Shippinno\Labs\Application\DataTransformer\LabDataTransformer;
use Shippinno\Labs\Domain\Model\Common\AnyOfSpecification;
use Shippinno\Labs\Domain\Model\Common\Specification;
use Shippinno\Labs\Domain\Model\Lab\Lab;
use Shippinno\Labs\Domain\Model\Lab\LabRepository;
use Shippinno\Labs\Domain\Model\Lab\CourseSpecificationFactory;

class AllCoursesQueryHandler implements QueryHandler
{
    /**
     * @var LabRepository
     */
    private $courseRepository;
    /**
     * @var CourseSpecificationFactory
     */
    private $courseSpecificationFactory;


    /**
     * @param LabRepository $courseRepository
     * @param LabDataTransformer $courseDataTransformer
     */
    public function __construct(
        LabRepository $courseRepository,
        CourseSpecificationFactory $courseSpecificationFactory
    ) {
        $this->courseRepository = $courseRepository;
        $this->courseSpecificationFactory = $courseSpecificationFactory;
    }

    /**
     * @param AllCoursesQuery $query
     * @return mixed
     */
    public function handle($query, LabDataTransformer $courseDataTransformer = null)
    {
        $specifications = array_map(function (Comparison $comparison) {
            return $this->createSpecification($comparison);
        }, $query->comparisons());

        $specification = new AnyOfSpecification(...$specifications);

        $courses = $this->courseRepository->satisfying($specification);
        $totalCount = $this->courseRepository->countSatisfying($specification);

        return [
            'resources' => array_map(function (Lab $course) use ($courseDataTransformer) {
                $courseDataTransformer->write($course);
                return $courseDataTransformer->read();
            }, $courses),
            'total' => $totalCount
        ];
    }

    private function createSpecification(Comparison $comparison): ?Specification
    {
        $specifications = [
            'name' => [
                Comparison::CONTAINS => function ($string) {
                    return $this->courseSpecificationFactory->courseNameContains($string);
                },
            ]
        ];

        /** @var Closure|null $create */
        $create = $specifications[$comparison->getField()][$comparison->getOperator()] ?? null;

        if (is_null($create)) {
            return null;
        }

        return $create($comparison->getValue()->getValue());
    }


}
