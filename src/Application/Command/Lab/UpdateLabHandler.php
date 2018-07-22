<?php

namespace Shippinno\Labs\Application\Command\Lab;

use Shippinno\Labs\Domain\Model\Common\UnauthorizedActionException;
use Shippinno\Labs\Domain\Model\Lab\LabId;
use Shippinno\Labs\Domain\Model\Lab\LabNotFoundException;
use Shippinno\Labs\Domain\Model\Lab\LabOwnershipAware;
use Shippinno\Labs\Domain\Model\Lab\LabRepository;
use Shippinno\Labs\Domain\Model\Lab\LabRepositoryAware;
use Shippinno\Labs\Domain\Model\User\UserId;
use Shippinno\Labs\Domain\Model\User\UserNotFoundException;
use Shippinno\Labs\Domain\Model\User\UserRepository;
use Shippinno\Labs\Domain\Model\User\UserRepositoryAware;
use Tanigami\ValueObjects\Web\Url;

class UpdateLabHandler
{
    use LabRepositoryAware;
    use UserRepositoryAware;
    use LabOwnershipAware;

    /**
     * @param LabRepository $labRepository
     * @param UserRepository $userRepository
     */
    public function __construct(LabRepository $labRepository, UserRepository $userRepository)
    {
        $this->setLabRepository($labRepository);
        $this->setUserRepository($userRepository);
    }

    /**
     * @param UpdateLab $command
     * @throws LabNotFoundException
     * @throws UnauthorizedActionException
     * @throws UserNotFoundException
     */
    public function handle(UpdateLab $command): void
    {
        $lab = $this->findLabOrFail(new LabId($command->labId()));
        $commander = $this->findUserOrFail(new UserId($command->commanderId()));
        $this->assertUserOwnsLab($commander, $lab);
        $lab->changeName($command->name());
        $lab->changeSubject($command->subject());
        $lab->changeOverview($command->overview());
        $lab->changeCapacity($command->capacity());
        $lab->changeImage(new Url($command->image()));
    }
}