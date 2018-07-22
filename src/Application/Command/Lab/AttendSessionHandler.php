<?php

namespace Shippinno\Labs\Application\Command\Lab;

use Shippinno\Labs\Domain\Model\Lab\LabId;
use Shippinno\Labs\Domain\Model\Lab\LabRepository;
use Shippinno\Labs\Domain\Model\Lab\LabRepositoryAware;
use Shippinno\Labs\Domain\Model\Lab\SessionId;
use Shippinno\Labs\Domain\Model\User\UserId;
use Shippinno\Labs\Domain\Model\User\UserRepository;
use Shippinno\Labs\Domain\Model\User\UserRepositoryAware;

class AttendSessionHandler
{
    use LabRepositoryAware;
    use UserRepositoryAware;

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
     * @param AttendSession $command
     * @throws \Shippinno\Labs\Domain\Model\Lab\LabNotFoundException
     * @throws \Shippinno\Labs\Domain\Model\User\UserNotFoundException
     */
    public function handle(AttendSession $command): void
    {
        $lab = $this->findLabOrFail(new LabId($command->labId()));
        $commander = $this->findUserOrFail(new UserId($command->commanderId()));
        $lab->addSessionAttendee(
            new SessionId($command->sessionId()),
            $commander
        );
    }
}