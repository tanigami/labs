<?php

namespace Shippinno\Labs\Tests\Unit\Application\Command\Lab;

use PHPUnit\Framework\TestCase;
use Shippinno\Labs\Application\Command\Lab\LeaveLab;
use Shippinno\Labs\Application\Command\Lab\LeaveLabHandler;
use Shippinno\Labs\Domain\Model\User\UserBuilder;
use Shippinno\Labs\Infrastructure\Domain\Model\Lab\InMemoryLabRepository;
use Shippinno\Labs\Infrastructure\Domain\Model\User\InMemoryUserRepository;
use Shippinno\Labs\Tests\Unit\Application\Service\Lab\LabBuilder;

class LeaveLabHandlerTest extends TestCase
{
    public function test()
    {
        $labRepository = new InMemoryLabRepository;
        $userRepository = new InMemoryUserRepository;

        $owner = UserBuilder::user()->build();
        $userToLeave = UserBuilder::user()->build();
        $userRepository->save($owner);
        $userRepository->save($userToLeave);

        $lab = LabBuilder::lab()->withOwnerId($owner->userId())->build();
        $lab->addMember($userToLeave, new \DateTimeImmutable());
        $labRepository->add($lab);

        $handler = new LeaveLabHandler($labRepository, $userRepository);
        $handler->handle(
            new LeaveLab(
                $userToLeave->userId()->id(),
                $lab->labId()->id()
            )
        );

        $this->assertFalse($lab->isMember($userToLeave));
    }
}