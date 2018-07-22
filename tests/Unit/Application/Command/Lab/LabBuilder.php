<?php

namespace Shippinno\Labs\Tests\Unit\Application\Service\Lab;

use Shippinno\Labs\Domain\Model\Lab\Lab;
use Shippinno\Labs\Domain\Model\Lab\LabId;
use Shippinno\Labs\Domain\Model\User\UserId;
use Tanigami\ValueObjects\Web\Url;

class LabBuilder
{
    /**
     * @var LabId
     */
    private $labId;

    /**
     * @var UserId
     */
    private $ownerId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $overview;

    /**
     * @var int
     */
    private $capacity;

    /**
     * @var null|Url
     */
    private $image;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->labId = new LabId;
        $this->ownerId = new UserId;
        $this->name = 'name';
        $this->subject = 'subject';
        $this->overview = 'overview';
        $this->capacity = 123;
        $this->image = new Url('http://example.com/image.jpg');
    }

    /**
     * @return self
     */
    public static function lab(): self
    {
        return new self;
    }

    /**
     * @param LabId $labId
     * @return self
     */
    public function withLabId(LabId $labId): self
    {
        $this->labId = $labId;

        return $this;
    }

    /**
     * @param UserId $ownerId
     * @return self
     */
    public function withOwnerId(UserId $ownerId): self
    {
        $this->ownerId = $ownerId;

        return $this;
    }

    /**
     * @param string $name
     * @return self
     */
    public function withName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $subject
     * @return self
     */
    public function withSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @param string $overview
     * @return self
     */
    public function withOverview(string $overview): self
    {
        $this->overview = $overview;

        return $this;
    }

    /**
     * @param string $capacity
     * @return self
     */
    public function withCapacity(string $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * @param Url|null $image
     * @return self
     */
    public function withImage(Url $image = null): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Lab
     */
    public function build(): Lab
    {
        return new Lab(
            $this->labId,
            $this->ownerId,
            $this->name,
            $this->subject,
            $this->overview,
            $this->capacity,
            $this->image
        );
    }
}
