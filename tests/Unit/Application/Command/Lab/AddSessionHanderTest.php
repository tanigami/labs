<?php

namespace Shippinno\Labs\Tests\Unit\Application\Command\Lab;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Shippinno\Labs\Application\Command\Lab\AddSession;
use Shippinno\Labs\Application\Command\Lab\AddSessionHandler;
use Shippinno\Labs\Domain\Model\Lab\SessionId;
use Shippinno\Labs\Domain\Model\User\UserBuilder;
use Shippinno\Labs\Infrastructure\Domain\Model\Lab\InMemoryLabRepository;
use Shippinno\Labs\Infrastructure\Domain\Model\User\InMemoryUserRepository;
use Shippinno\Labs\Tests\Unit\Application\Command\Lab\LabBuilder;

class AddSessionHanderTest extends TestCase
{
    public function test()
    {
        $labRepository = new InMemoryLabRepository;
        $userRepository = new InMemoryUserRepository;

        $user = UserBuilder::user()->build();
        $userRepository->save($user);

        $lab = LabBuilder::lab()->withOwnerId($user->userId())->build();
        $labRepository->add($lab);

        $sessionId = (new SessionId);
        $start = new DateTimeImmutable('2019-01-01 00:00:00');
        $end = new DateTimeImmutable('2019-01-01 01:00:00');

        $handler = new AddSessionHandler($labRepository, $userRepository);
        $handler->handle(
            new AddSession(
                $user->userId()->id(),
                $lab->labId()->id(),
                $sessionId->id(),
                'TITLE',
                $start,
                $end,
                'DESCRIPTION'
            )
        );

        $session = $lab->sessionOfId($sessionId);
        $this->assertSame('TITLE', $session->title());
        $this->assertSame($start, $session->hours()->start());
        $this->assertSame($end, $session->hours()->end());
        $this->assertSame('DESCRIPTION', $session->description());
    }
}

