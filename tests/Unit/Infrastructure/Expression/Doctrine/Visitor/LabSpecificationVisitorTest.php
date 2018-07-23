<?php

namespace Shippinno\Labs\Tests\Unit\Infrastructure\Expression\Doctrine\Visitor;


use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\ExpressionBuilder;
use PHPUnit\Framework\TestCase;
use Shippinno\Labs\Infrastructure\Domain\Model\Lab\DoctrineLabSpecificationFactory;
use Shippinno\Labs\Infrastructure\Expression\Doctrine\Visitor\LabSpecificationVisitor;

class LabSpecificationVisitorTest extends TestCase
{
    public function test()
    {
        $builder = Criteria::expr();
        $expr = Criteria::create()
            ->where($builder->contains('name', 'hoge'))
            ->andWhere($builder->eq('open_to_join', true))
            ->getWhereExpression();

        $visitor = new LabSpecificationVisitor(new DoctrineLabSpecificationFactory());
        

        $this->markTestSkipped();
    }
}