<?php

namespace Shippinno\Labs\Application\Command\Lab;

use Shippinno\Labs\Domain\Model\Common\UnauthorizedActionException;
use Shippinno\Labs\Domain\Model\Lab\LabId;
use Shippinno\Labs\Domain\Model\Lab\LabNotFoundException;
use Shippinno\Labs\Domain\Model\Lab\LabOwnershipAware;
use Shippinno\Labs\Domain\Model\Lab\LabRepository;
use Shippinno\Labs\Domain\Model\Lab\LabRepositoryAware;
use Shippinno\Labs\Domain\Model\Lab\SessionId;
use Shippinno\Labs\Domain\Model\User\UserId;
use Shippinno\Labs\Domain\Model\User\UserNotFoundException;
use Shippinno\Labs\Domain\Model\User\UserRepository;
use Shippinno\Labs\Domain\Model\User\UserRepositoryAware;
use Tanigami\ValueObjects\Time\TimeRange;

class UpdateSessionHandler
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
     * @param UpdateSession $command
     * @throws UnauthorizedActionException
     * @throws LabNotFoundException
     * @throws UserNotFoundException
     */
    public function handle(UpdateSession $command): void
    {
        $lab = $this->findLabOrFail(new LabId($command->labId()));
        $commander = $this->findUserOrFail(new UserId($command->commanderId()));
        $this->assertUserOwnsLab($commander, $lab);
        $lab->updateSession(
            new SessionId($command->sessionId()),
            $command->title(),
            new TimeRange($command->start(), $command->end()),
            $command->description()
        );
    }
}
