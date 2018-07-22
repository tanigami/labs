<?php

namespace Shippinno\Labs\Tests\Unit\Application\Command\Lab;

use PHPUnit\Framework\TestCase;
use Shippinno\Labs\Application\Command\Lab\DeleteLab;
use Shippinno\Labs\Application\Command\Lab\DeleteLabHandler;
use Shippinno\Labs\Domain\Model\User\UserBuilder;
use Shippinno\Labs\Infrastructure\Domain\Model\Lab\InMemoryLabRepository;
use Shippinno\Labs\Infrastructure\Domain\Model\User\InMemoryUserRepository;
use Shippinno\Labs\Tests\Unit\Application\Service\Lab\LabBuilder;

class DeleteLabHandlerTest extends TestCase
{
    public function test()
    {
        $labRepository = new InMemoryLabRepository;
        $userRepository = new InMemoryUserRepository;

        $user = UserBuilder::user()->build();
        $userRepository->save($user);

        $lab = LabBuilder::lab()->withOwnerId($user->userId())->build();
        $labRepository->add($lab);

        $handler = new DeleteLabHandler($labRepository, $userRepository);
        $command = new DeleteLab($user->userId()->id(), $lab->labId()->id());
        $handler->handle($command);

        $this->assertNull($labRepository->labOfId($lab->labId()));
    }
}