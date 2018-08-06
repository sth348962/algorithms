<?php

namespace Sth348962\Algorithms\Sorters;

abstract class Sorter
{
    /**
     * @var callable Функция сравнения двух элементов сортируемого массива
     */
    protected $sortFn;

    public function __construct(callable $sortFn)
    {
        $this->sortFn = $sortFn;
    }

    abstract public function sort(array $original): array;
}