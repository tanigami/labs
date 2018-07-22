<?php

namespace Shippinno\Labs\Tests\Unit\Application\Command\Lab;

use PHPUnit\Framework\TestCase;
use Shippinno\Labs\Application\Command\Lab\UpdateLab;
use Shippinno\Labs\Application\Command\Lab\UpdateLabHandler;
use Shippinno\Labs\Domain\Model\User\UserBuilder;
use Shippinno\Labs\Infrastructure\Domain\Model\Lab\InMemoryLabRepository;
use Shippinno\Labs\Infrastructure\Domain\Model\User\InMemoryUserRepository;
use Shippinno\Labs\Tests\Unit\Application\Service\Lab\LabBuilder;

class UpdateLabHandlerTest extends TestCase
{
    public function test()
    {
        $labRepository = new InMemoryLabRepository;
        $userRepository = new InMemoryUserRepository;

        $user = UserBuilder::user()->build();
        $userRepository->save($user);

        $lab = LabBuilder::lab()->withOwnerId($user->userId())->build();
        $labRepository->add($lab);

        $handler = new UpdateLabHandler($labRepository, $userRepository);
        $command =
            UpdateLabBuilder::command()
                ->withCommanderId($user->userId()->id())
                ->withLabId($lab->labId()->id())
                ->withName('NEW_LAB_NAME')
                ->withSubject('NEW_LAB_SUBJECT')
                ->withOverview('NEW_LAB_OVERVIEW')
                ->withCapacity(99999)
                ->withImage('http://example.com/NEW-IMAGE.jpg')
                ->build();
        $handler->handle($command);

        $this->assertSame('NEW_LAB_NAME', $lab->name());
        $this->assertSame('NEW_LAB_SUBJECT', $lab->subject());
        $this->assertSame('NEW_LAB_OVERVIEW', $lab->overview());
        $this->assertSame(99999, $lab->capacity());
        $this->assertSame('http://example.com/NEW-IMAGE.jpg', $lab->image()->url());
    }
}

class UpdateLabBuilder
{
    private $labId;
    private $commanderId;
    private $name;
    private $subject;
    private $overview;
    private $capacity;
    private $image;

    public function __construct()
    {
        $this->labId = 'labId';
        $this->commanderId = 'commanderId';
        $this->name = 'name';
        $this->subject = 'subject';
        $this->overview = 'overview';
        $this->capacity = 5;
        $this->image = 'http://example.com/image.jpg';
    }

    public static function command()
    {
        return new self;
    }

    public function withCommanderId(string $commanderId)
    {
        $this->commanderId = $commanderId;

        return $this;
    }

    public function withLabId(string $labId)
    {
        $this->labId = $labId;

        return $this;
    }

    public function withName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    public function withSubject(string $subject)
    {
        $this->subject = $subject;

        return $this;
    }

    public function withOverview(string $overview)
    {
        $this->overview = $overview;

        return $this;
    }

    public function withCapacity(int $capacity)
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function withImage(?string $image)
    {
        $this->image = $image;

        return $this;
    }

    public function build()
    {
        return new UpdateLab(
            $this->commanderId,
            $this->labId,
            $this->name,
            $this->subject,
            $this->overview,
            $this->capacity,
            $this->image
        );
    }
}