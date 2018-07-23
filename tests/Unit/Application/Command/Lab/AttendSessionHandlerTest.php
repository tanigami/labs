<?php

namespace Shippinno\Labs\Tests\Unit\Application\Command\Lab;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Shippinno\Labs\Application\Command\Lab\AttendSession;
use Shippinno\Labs\Application\Command\Lab\AttendSessionHandler;
use Shippinno\Labs\Domain\Model\Lab\SessionId;
use Shippinno\Labs\Domain\Model\User\UserBuilder;
use Shippinno\Labs\Infrastructure\Domain\Model\Lab\InMemoryLabRepository;
use Shippinno\Labs\Infrastructure\Domain\Model\User\InMemoryUserRepository;
use Shippinno\Labs\Tests\Unit\Application\Command\Lab\LabBuilder;
use Tanigami\ValueObjects\Time\TimeRange;

class AttendSessionHandlerTest extends TestCase
{
    public function test()
    {
        $labRepository = new InMemoryLabRepository;
        $userRepository = new InMemoryUserRepository;

        $user = UserBuilder::user()->build();
        $userRepository->save($user);

        $lab = LabBuilder::lab()->withOwnerId($user->userId())->build();
        $sessionId = new SessionId;
        $lab->addSession(
            $sessionId,
            'title',
            new TimeRange(new DateTimeImmutable('2019-01-01 00:00:00'), new DateTimeImmutable('2019-01-01 01:00:00')),
            'description'
        );
        $labRepository->add($lab);

        $handler = new AttendSessionHandler($labRepository, $userRepository);
        $handler->handle(
            new AttendSession(
                $user->userId()->id(),
                $lab->labId()->id(),
                $sessionId->id()
            )
        );

        $this->assertTrue($lab->sessionOfId($sessionId)->isAttendee($user));
    }
}