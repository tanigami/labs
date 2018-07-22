<?php

namespace Shippinno\Labs\Application\Command\Lab;

use Shippinno\Labs\Domain\Model\Lab\Lab;
use Shippinno\Labs\Domain\Model\Lab\LabId;
use Shippinno\Labs\Domain\Model\Lab\LabRepository;
use Shippinno\Labs\Domain\Model\Lab\LabRepositoryAware;
use Shippinno\Labs\Domain\Model\User\UserId;
use Shippinno\Labs\Domain\Model\User\UserNotFoundException;
use Shippinno\Labs\Domain\Model\User\UserRepository;
use Shippinno\Labs\Domain\Model\User\UserRepositoryAware;
use Tanigami\ValueObjects\Web\Url;

class CreateLabHandler
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
     * @param CreateLab $command
     * @throws UserNotFoundException
     */
    public function handle(CreateLab $command): void
    {
        $commander = $this->findUserOrFail(new UserId($command->commanderId()));
        $lab = new Lab(
            new LabId($command->labId()),
            $commander->userId(),
            $command->name(),
            $command->subject(),
            $command->overview(),
            $command->capacity(),
            is_null($command->image()) ? null : new Url($command->image())
        );
        $this->labRepository()->add($lab);
    }
}