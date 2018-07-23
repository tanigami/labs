<?php

namespace Shippinno\Labs\Tests\Unit\Application\Query\Lab;

use Doctrine\Common\Collections\Criteria;
use PHPUnit\Framework\TestCase;
use Shippinno\Labs\Application\Query\Lab\FilterLabs;
use Shippinno\Labs\Application\Query\Lab\FilterLabsHandler;
use Shippinno\Labs\Domain\Model\Lab\LabSpecificationFactory;
use Shippinno\Labs\Infrastructure\Domain\Model\Lab\InMemoryLabRepository;
use Shippinno\Labs\Tests\Unit\Application\Command\Lab\LabAsIsDataTransformer;
use Shippinno\Labs\Tests\Unit\Application\Command\Lab\LabBuilder;

class FilterLabsHandlerTest extends TestCase
{
    public function test()
    {
        $labRepository = new InMemoryLabRepository;
        $labRepository->add(LabBuilder::lab()->build());
        $labRepository->add(LabBuilder::lab()->build());
        $labRepository->add(LabBuilder::lab()->withName('!HOGE!')->build());

        $builder = Criteria::expr();
        $expression = Criteria::create()
            ->where($builder->contains('name', 'OG'))
            ->andWhere($builder->eq('open_to_join', true))
            ->getWhereExpression();
        $handler = new FilterLabsHandler($labRepository, new LabSpecificationFactory, new LabAsIsDataTransformer);
        $result = $handler->handle(new FilterLabs($expression));
        $this->assertCount(1, $result['resources']);
    }
}