<?php

namespace Shippinno\Labs\Tests\Unit\Application\Command\Lab;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Shippinno\Labs\Application\Command\Lab\UpdateSession;
use Shippinno\Labs\Application\Command\Lab\UpdateSessionHandler;
use Shippinno\Labs\Domain\Model\Lab\SessionId;
use Shippinno\Labs\Domain\Model\User\UserBuilder;
use Shippinno\Labs\Infrastructure\Domain\Model\Lab\InMemoryLabRepository;
use Shippinno\Labs\Infrastructure\Domain\Model\User\InMemoryUserRepository;
use Shippinno\Labs\Tests\Unit\Application\Command\Lab\LabBuilder;
use Tanigami\ValueObjects\Time\TimeRange;

class UpdateSessionHandlerTest extends TestCase
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

        $start = new DateTimeImmutable('2019-01-01 00:00:00');
        $end = new DateTimeImmutable('2019-01-01 10:00:00');

        $handler = new UpdateSessionHandler($labRepository, $userRepository);
        $handler->handle(
            new UpdateSession(
                $user->userId()->id(),
                $lab->labId()->id(),
                $sessionId->id(),
                'NEW_SESSION_TITLE',
                $start,
                $end,
                'NEW_SESSION_DESCRIPTION'
            )
        );

        $session = $lab->sessionOfId($sessionId);
        $this->assertSame('NEW_SESSION_TITLE', $session->title());
        $this->assertSame($start, $session->hours()->start());
        $this->assertSame($end, $session->hours()->end());
        $this->assertSame('NEW_SESSION_DESCRIPTION', $session->description());
    }
}