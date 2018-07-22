<?php

namespace Shippinno\Labs\Application\Command\Lab;

use Shippinno\Labs\Domain\Model\Lab\LabId;
use Tanigami\ValueObjects\Web\Url;

class CreateLab
{
    /**
     * @var string
     */
    private $commanderId;

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
     * @var null|string
     */
    private $image;

    /**
     * @var string
     */
    private $labId;

    /**
     * @param string $commanderId
     * @param string $name
     * @param string $subject
     * @param string $overview
     * @param int $capacity
     * @param string|null $image
     */
    public function __construct(
        string $commanderId,
        string $name,
        string $subject,
        string $overview,
        int $capacity,
        string $image = null
    ) {
        $this->commanderId = $commanderId;
        $this->name = $name;
        $this->subject = $subject;
        $this->overview = $overview;
        $this->capacity = $capacity;
        $this->image = $image;
        $this->labId = (new LabId)->id();
    }

    /**
     * @return string
     */
    public function commanderId(): string
    {
        return $this->commanderId;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function subject(): string
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function overview(): string
    {
        return $this->overview;
    }

    /**
     * @return int
     */
    public function capacity(): int
    {
        return $this->capacity;
    }

    /**
     * @return null|string
     */
    public function image(): ?string
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function labId(): string
    {
        return $this->labId;
    }
}
