<?php

namespace Shippinno\Labs\Domain\Model\Lab;

trait LabRepositoryAware
{
    /**
     * @var LabRepository
     */
    protected $labRepository;

    /**
     * @param LabRepository $labRepository
     */
    public function setLabRepository(LabRepository $labRepository)
    {
        $this->labRepository = $labRepository;
    }

    /**
     * @return LabRepository
     */
    public function labRepository(): LabRepository
    {
        return $this->labRepository;
    }

    /**
     * @param LabId $labId
     * @return Lab
     * @throws LabNotFoundException
     */
    protected function findLabOrFail(LabId $labId): Lab
    {
        $lab = $this->labRepository()->labOfId($labId);
        if (is_null($lab)) {
            throw new LabNotFoundException;
        }

        return $lab;
    }
}
