<?php
/**
 * Created by PhpStorm.
 * User: tanigami
 * Date: 2018/07/23
 * Time: 10:51
 */

namespace Shippinno\Labs\Infrastructure\Expression\Doctrine\Visitor;

use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\Common\Collections\Expr\CompositeExpression;
use Doctrine\Common\Collections\Expr\ExpressionVisitor;
use Doctrine\Common\Collections\Expr\Value;
use Shippinno\Labs\Domain\Model\Common\AnyOfSpecification;
use Shippinno\Labs\Domain\Model\Common\OneOfSpecification;
use Shippinno\Labs\Domain\Model\Lab\LabSpecificationFactory;

class LabSpecificationVisitor extends ExpressionVisitor
{
    /**
     * @var LabSpecificationFactory
     */
    private $labSpecificationFactory;

    /**
     * @param LabSpecificationFactory $labSpecificationFactory
     */
    public function __construct(LabSpecificationFactory $labSpecificationFactory)
    {
        $this->labSpecificationFactory = $labSpecificationFactory;
    }

    /**
     * Converts a comparison expression into the target query language output.
     *
     * @param Comparison $comparison
     *
     * @return mixed
     */
    public function walkComparison(Comparison $comparison)
    {
        $field = $comparison->getField();
        $value = $comparison->getValue()->getValue();
        $operator = $comparison->getOperator();

        switch ($field) {
            case 'name':
                switch ($operator) {
                    case Comparison::CONTAINS:
                        return $this->labSpecificationFactory->nameContains($value);
                }
                break;
            case 'open_to_join':
                switch ($operator) {
                    case Comparison::IS:
                        return $value
                            ? $this->labSpecificationFactory->openToJoin()
                            : $this->labSpecificationFactory->openToJoin()->not()
                        ;
                }
        }

        return null;
    }

    /**
     * Converts a value expression into the target query language part.
     *
     * @param Value $value
     *
     * @return mixed
     */
    public function walkValue(Value $value)
    {
        return $value->getValue();
    }

    /**
     * Converts a composite expression into the target query language output.
     *
     * @param CompositeExpression $expr
     *
     * @return mixed
     */
    public function walkCompositeExpression(CompositeExpression $expr)
    {
        $expressionList = [];

        foreach ($expr->getExpressionList() as $child) {
            $expressionList[] = $this->dispatch($child);
        }

        switch($expr->getType()) {
            case CompositeExpression::TYPE_AND:
                return new AnyOfSpecification(...$expressionList);

            case CompositeExpression::TYPE_OR:
                return new OneOfSpecification(...$expressionList);

            default:
                throw new \RuntimeException("Unknown composite " . $expr->getType());
        }
    }
}