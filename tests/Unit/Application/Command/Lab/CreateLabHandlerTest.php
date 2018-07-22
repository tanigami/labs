<?php

namespace Shippinno\Labs\Tests\Unit\Application\Command\Lab;

use PHPUnit\Framework\TestCase;
use Shippinno\Labs\Application\Command\Lab\CreateLab;
use Shippinno\Labs\Application\Command\Lab\CreateLabHandler;
use Shippinno\Labs\Domain\Model\Lab\LabId;
use Shippinno\Labs\Domain\Model\User\UserBuilder;
use Shippinno\Labs\Domain\Model\User\UserId;
use Shippinno\Labs\Infrastructure\Domain\Model\Lab\InMemoryLabRepository;
use Shippinno\Labs\Infrastructure\Domain\Model\User\InMemoryUserRepository;
use Tanigami\ValueObjects\Web\Url;

class CreateLabHandlerTest extends TestCase
{
    /**
     * @dataProvider createLabDataProvider
     */
    public function testLabIsInRepositoryAfterCreating($image)
    {
        $labRepository = new InMemoryLabRepository;
        $userRepository = new InMemoryUserRepository;
        $userRepository->save(UserBuilder::user()->withUserId(new UserId('OWNER_ID'))->build());
        $handler = new CreateLabHandler($labRepository, $userRepository);
        $command = CreateLabRequestBuilder::request()
            ->withOwnerId('OWNER_ID')
            ->withName('NAME')
            ->withSubject('SUBJECT')
            ->withOverview('OVERVIEW')
            ->withCapacity(123)
            ->withImage($image)
            ->build();
        $handler->handle($command);
        $lab = $labRepository->labOfId(new LabId($command->labId()));
        $this->assertTrue((new UserId('OWNER_ID'))->equals($lab->ownerId()));
        $this->assertSame('NAME', $lab->name());
        $this->assertSame('SUBJECT', $lab->subject());
        $this->assertSame('OVERVIEW', $lab->overview());
        $this->assertSame(123, $lab->capacity());
        // TODO:
        $this->assertTrue(
            is_null($image)
                ? is_null($lab->image())
                : (new Url($image))->equals($lab->image())
        );
    }

    /**
     * @expectedException \Shippinno\Labs\Domain\Model\User\UserNotFoundException
     */
    public function testExceptionIsThrownIfUserNotFound()
    {
        $labRepository = new InMemoryLabRepository;
        $userRepository = new InMemoryUserRepository;
        $userRepository->save(UserBuilder::user()->withUserId(new UserId('OWNER_ID'))->build());
        $handler = new CreateLabHandler($labRepository, $userRepository);
        $handler->handle(
            CreateLabRequestBuilder::request()->withOwnerId('THIS_DOES_NOT_EXIST')->build()
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionIsThrownIfImageUrlIsInvalid()
    {
        $labRepository = new InMemoryLabRepository;
        $userRepository = new InMemoryUserRepository;
        $userRepository->save(UserBuilder::user()->withUserId(new UserId('OWNER_ID'))->build());
        $handler = new CreateLabHandler($labRepository, $userRepository);
        $handler->handle(
            CreateLabRequestBuilder::request()
                ->withOwnerId('OWNER_ID')
                ->withImage('THIS_IS_NOT_URL')
                ->build()
        );
    }

    public function createLabDataProvider()
    {
        return [
            'without image' => [null],
            'with image' => ['http://example.com/IMAGE.jpg']
        ];
    }
}

class CreateLabRequestBuilder
{
    private $ownerId;
    private $name;
    private $subject;
    private $overview;
    private $capacity;
    private $image;

    public function __construct()
    {
        $this->ownerId = 'ownerId';
        $this->name = 'name';
        $this->subject = 'subject';
        $this->overview = 'overview';
        $this->capacity = 5;
        $this->image = 'http://example.com/image.jpg';
    }

    public static function request()
    {
        return new self;
    }

    public function withOwnerId(string $ownerId)
    {
        $this->ownerId = $ownerId;

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
        return new CreateLab(
            $this->ownerId,
            $this->name,
            $this->subject,
            $this->overview,
            $this->capacity,
            $this->image
        );
    }
}