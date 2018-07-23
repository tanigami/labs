<?php

namespace Shippinno\Labs\Tests\Unit\Application\Command\Lab;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Shippinno\Labs\Application\Command\Lab\RemoveSession;
use Shippinno\Labs\Application\Command\Lab\RemoveSessionHandler;
use Shippinno\Labs\Domain\Model\Lab\SessionId;
use Shippinno\Labs\Domain\Model\User\UserBuilder;
use Shippinno\Labs\Infrastructure\Domain\Model\Lab\InMemoryLabRepository;
use Shippinno\Labs\Infrastructure\Domain\Model\User\InMemoryUserRepository;
use Shippinno\Labs\Tests\Unit\Application\Command\Lab\LabBuilder;
use Tanigami\ValueObjects\Time\TimeRange;

class RemoveSessionHandlerTest extends TestCase
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

        $lab->addSession(
            $sessionId,
            'title',
            new TimeRange(
                new DateTimeImmutable('1970-01-01 00:00:00'),
                new DateTimeImmutable('1970-01-01 10:00:00')
            ),
            'description'
        );

        $handler = new RemoveSessionHandler($labRepository, $userRepository);
        $handler->handle(
            new RemoveSession(
                $user->userId()->id(),
                $lab->labId()->id(),
                $sessionId->id()
            )
        );

        $this->assertNull($lab->sessionOfId($sessionId));
    }
}