<?php

namespace Shippinno\Labs\Application\Query\Lab;

use Shippinno\Labs\Application\DataTransformer\Lab\LabDataTransformer;
use Shippinno\Labs\Application\DataTransformer\Lab\LabDtoDataTransformer;
use Shippinno\Labs\Domain\Model\Lab\LabId;
use Shippinno\Labs\Domain\Model\Lab\LabNotFoundException;
use Shippinno\Labs\Domain\Model\Lab\LabRepository;
use Shippinno\Labs\Domain\Model\Lab\LabRepositoryAware;

class FetchLabHandler
{
    use LabRepositoryAware;

    /**
     * @var LabDataTransformer
     */
    private $labDataTransformer;

    /**
     * @param LabRepository $labRepository
     */
    public function __construct(
        LabRepository $labRepository,
        LabDataTransformer $labDataTransformer
    ) {
        $this->setLabRepository($labRepository);
        $this->labDataTransformer = $labDataTransformer;
    }

    /**
     * @param FetchLab $query
     * @return mixed
     * @throws LabNotFoundException
     */
    public function handle(FetchLab $query)
    {
        $lab = $this->findLabOrFail(new LabId($query->labId()));
        $this->labDataTransformer->write($lab);

        return $this->labDataTransformer->read();
    }
}
