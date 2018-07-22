<?php

namespace Shippinno\Labs\Tests\Unit\Application\Command\Lab;

use PHPUnit\Framework\TestCase;
use Shippinno\Labs\Application\Command\Lab\JoinLab;
use Shippinno\Labs\Application\Command\Lab\JoinLabHandler;
use Shippinno\Labs\Domain\Model\User\UserBuilder;
use Shippinno\Labs\Infrastructure\Domain\Model\Lab\InMemoryLabRepository;
use Shippinno\Labs\Infrastructure\Domain\Model\User\InMemoryUserRepository;
use Shippinno\Labs\Tests\Unit\Application\Service\Lab\LabBuilder;

class JoinLabHandlerTest extends TestCase
{
    public function test()
    {
        $labRepository = new InMemoryLabRepository;
        $userRepository = new InMemoryUserRepository;

        $owner = UserBuilder::user()->build();
        $userToJoin = UserBuilder::user()->build();
        $userRepository->save($owner);
        $userRepository->save($userToJoin);

        $lab = LabBuilder::lab()->withOwnerId($owner->userId())->build();
        $labRepository->add($lab);

        $handler = new JoinLabHandler($labRepository, $userRepository);
        $handler->handle(
            new JoinLab(
                $userToJoin->userId()->id(),
                $lab->labId()->id()
            )
        );

        $this->assertTrue($lab->isMember($userToJoin));
    }
}