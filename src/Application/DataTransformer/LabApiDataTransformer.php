<?php

namespace Shippinno\Labs\Application\DataTransformer;

use Closure;
use DateTime;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use Shippinno\Labs\Domain\Model\Lab\Lab;
use Shippinno\Labs\Domain\Model\Lab\Member;
use Shippinno\Labs\Domain\Model\Lab\Session;

class LabApiDataTransformer extends TransformerAbstract implements LabDataTransformer
{
    /**
     * @var Lab|Lab[]
     */
    private $data;

    /**
     * {@inheritdoc}
     */
    public function write(Lab $lab): void
    {
        $this->data = $lab;
    }

    /**
     * {@inheritdoc}
     */
    public function writeAll(Lab ...$courses): void
    {
        $this->data = $courses;
    }

    /**
     * @return Item|Collection
     */
    public function read()
    {
        if (is_array($this->data)) {
            return new Collection($this->data, $this->transformer());
        }

        return new Item($this->data, $this->transformer());
    }

    /**
     * @return Closure
     */
    private function transformer(): Closure
    {
        return function (Lab $course) {
            return [
                'id' => $course->courseId()->id(),
                'name' => $course->name(),
                'seats' => $course->seats(),
                'enrollments' => $course->members()->map(
                    function (Member $enrollment) {
                        return [
                            'learner_id' => $enrollment->learnerId()->id(),
                            'enrolled_at' => $enrollment->enrolledAt()->format(DateTime::ISO8601),
                        ];
                    }
                )->toArray(),
                'sessions' => $course->sessions()->map(
                    function (Session $session) {
                        return [
                            'id' => $session->sessionId()->id(),
                            'title' => $session->title(),
                            'start' => $session->hours()->start()->format(DateTime::ISO8601),
                            'end' => $session->hours()->end()->format(DateTime::ISO8601),
                        ];
                    }
                )->toArray(),
            ];
        };
    }
}