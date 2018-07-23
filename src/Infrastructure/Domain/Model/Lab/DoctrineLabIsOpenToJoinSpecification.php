<?php
/**
 * Created by PhpStorm.
 * User: tanigami
 * Date: 2018/07/23
 * Time: 11:34
 */

namespace Shippinno\Labs\Infrastructure\Domain\Model\Lab;


use Happyr\DoctrineSpecification\Spec;
use Shippinno\Labs\Domain\Model\Lab\LabIsOpenToJoinSpecification;

class DoctrineLabIsOpenToJoinSpecification extends LabIsOpenToJoinSpecification
{
    /**
     * {@inheritdoc}
     */
    protected function getSpec()
    {
        return Spec::like('name', 'full');
    }
}