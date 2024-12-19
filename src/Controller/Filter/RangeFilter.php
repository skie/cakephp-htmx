<?php
declare(strict_types=1);

namespace App\Controller\Filter;

use Cake\Controller\Controller;
use CakeDC\SearchFilter\Filter\AbstractFilter;

class RangeFilter extends AbstractFilter
{
    protected array $properties = [
        'type' => 'range',
    ];

    protected object|array|null $conditions = [
        self::COND_BETWEEN => 'Between',
    ];
}
