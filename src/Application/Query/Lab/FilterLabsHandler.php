<?php

namespace Shippinno\Labs\Application\Query\Lab;

use Closure;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Shippinno\Labs\Application\DataTransformer\LabDataTransformer;
use Shippinno\Labs\Domain\Model\Common\AnyOfSpecification;
use Shippinno\Labs\Domain\Model\Common\Specification;
use Shippinno\Labs\Domain\Model\Lab\Lab;
use Shippinno\Labs\Domain\Model\Lab\LabRepository;
use Shippinno\Labs\Domain\Model\Lab\LabSpecificationFactory;
use Shippinno\Labs\Infrastructure\Expression\Doctrine\Visitor\LabSpecificationVisitor;

class FilterLabsHandler
{
    /**
     * @var LabRepository
     */
    private $labRepository;

    /**
     * @var LabSpecificationFactory
     */
    private $labSpecificationFactory;

    /**
     * @var LabDataTransformer
     */
    private $labDataTransformer;

    /**
     * @param LabRepository $labRepository
     * @param LabSpecificationFactory $labSpecificationFactory
     * @param LabSpecificationVisitor $labSpecificationVisitor
     * @param LabDataTransformer $labDataTransformer
     */
    public function __construct(
        LabRepository $labRepository,
        LabSpecificationFactory $labSpecificationFactory,
        LabDataTransformer $labDataTransformer
    ) {
        $this->labRepository = $labRepository;
        $this->labSpecificationFactory = $labSpecificationFactory;
        $this->labDataTransformer = $labDataTransformer;
    }

    /**
     * @param FilterLabs $query
     * @return mixed
     */
    public function handle(FilterLabs $query)
    {
        $visitor = new LabSpecificationVisitor($this->labSpecificationFactory);
        $specification = $visitor->dispatch($query->expression());

        $courses = $this->labRepository->satisfying($specification);
        $totalCount = $this->labRepository->countSatisfying($specification);

        return [
            'resources' => array_map(function (Lab $course) {
                $this->labDataTransformer->write($course);
                return $this->labDataTransformer->read();
            }, $courses),
            'total' => $totalCount
        ];
    }
}
