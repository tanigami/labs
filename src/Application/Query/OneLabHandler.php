<?php

namespace Shippinno\Labs\Application\Query;

use Shippinno\Labs\Application\DataTransformer\LabDataTransformer;
use Shippinno\Labs\Application\DataTransformer\LabDtoDataTransformer;
use Shippinno\Labs\Domain\Model\Lab\LabId;
use Shippinno\Labs\Domain\Model\Lab\LabNotFoundException;
use Shippinno\Labs\Domain\Model\Lab\LabRepository;
use Shippinno\Labs\Domain\Model\Lab\LabRepositoryAware;

class OneLabHandler implements QueryHandler
{
    use LabRepositoryAware;

    /**
     * @param LabRepository $labRepository
     */
    public function __construct(
        LabRepository $labRepository
    ) {
        $this->setLabRepository($labRepository);
    }

    /**
     * @param OneLab $query
     * @return mixed;
     * @throws LabNotFoundException
     */
    public function handle($query, LabDataTransformer $labDataTransformer = null)
    {
        $lab = $this->findLabOrFail(new LabId($query->labId()));

        if (is_null($labDataTransformer)) {
            $labDataTransformer = new LabDtoDataTransformer;
        }

        $labDataTransformer->write($lab);

        return $labDataTransformer->read();
    }
}