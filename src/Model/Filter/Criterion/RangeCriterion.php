<?php
declare(strict_types=1);

namespace App\Model\Filter\Criterion;

use Cake\Database\Expression\QueryExpression;
use Cake\ORM\Query;
use CakeDC\SearchFilter\Filter\AbstractFilter;
use CakeDC\SearchFilter\Model\Filter\Criterion\BaseCriterion;

class RangeCriterion extends BaseCriterion
{

    protected $field;

    public function __construct($field)
    {
        $this->field = $field;
    }

    public function __invoke(Query $query, string $condition, array $values, array $criteria, array $options): Query
    {
        $filter = $this->buildFilter($condition, $values, $criteria, $options);
        if (!empty($filter)) {
            return $query->where($filter);
        }

        return $query;
    }

    public function buildFilter(string $condition, array $values, array $criteria, array $options = []): ?callable
    {
        return function (QueryExpression $exp) use ($values) {
            if (!empty($values['from']) && !empty($values['to'])) {
                return $exp->between($this->field, $values['from'], $values['to']);
            }
            return $exp;
        };
    }

    public function isApplicable($value, string $condition): bool
    {
        return !empty($value['from']) || !empty($value['to']);
    }
}
