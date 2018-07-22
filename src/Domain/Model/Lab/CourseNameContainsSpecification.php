<?php
/**
 * Created by PhpStorm.
 * UserResourse: tanigami
 * Date: 2018/07/12
 * Time: 19:53
 */

namespace Shippinno\Labs\Domain\Model\Lab;


use Shippinno\Labs\Domain\Model\Common\Specification;

class CourseNameContainsSpecification extends Specification
{
    /**
     * @var string
     */
    protected $string;

    /**
     * @param string $string
     */
    public function __construct(string $string)
    {
        parent::__construct();
        $this->string = $string;
    }

    /**
     * @param Lab $entity
     * @return bool
     */
    public function isSatisfiedBy($course): bool
    {
        return strpos($course->name(), $this->string) !== false;
    }
}