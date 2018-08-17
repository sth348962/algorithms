<?php

declare(strict_types=1);

namespace Sth348962\Algorithms\Permutations;

use InvalidArgumentException;

class NarayanaAlgorithm
{
    protected $sortFn;

    /**
     * @param callable $sortFn Функция, которая сравнивает элементы данной перестановки
     */
    public function __construct(callable $sortFn)
    {
        $this->sortFn = $sortFn;
    }

    /**
     * Возвращает по данной перестановке следующую за ней перестановку (в лексикографическом порядке).
     *
     * @param mixed[] $original
     *
     * @throws \InvalidArgumentException
     *
     * @return null|mixed[]
     */
    public function next(array $original): ?array
    {
        // Максимальный индекс, элемент которого меньше элемента с индексом $k + 1
        $k = -1;

        // Максимальный индекс, элемент которого больше элемента с индексом $k
        $l = -1;

        // Т.к. мы ищем максимальные индексы $k и $l, начинаем поиски с конца массива
        $length = count($original);
        $i = $length - 1;
        while ($i-- > 0) {
            $tmp = call_user_func($this->sortFn, $original[$i], $original[$i + 1]);
            if (0 === $tmp) {
                // Если наткнулись на одинаковые элементы
                throw new InvalidArgumentException('have come across equal elements');
            }

            if ($tmp > 0) {
                continue;
            }

            $k = $i;
            $l = $i + 1;

            // Т.к. мы ищем максимальный индекс $j, то можно начинать с конца
            $j = $length;
            while ($j-- && $j > $l) {
                $tmp = call_user_func($this->sortFn, $original[$k], $original[$j]);
                if (0 === $tmp) {
                    // Если наткнулись на одинаковые элементы
                    throw new InvalidArgumentException('have come across equal elements');
                }

                if ($tmp < 0) {
                    $l = $j;
                }
            }

            break;
        }

        if (-1 === $k) {
            // Если это последняя перестановка
            return null;
        }

        // Меняем местами элементы под индексами $k и $l
        [$original[$k], $original[$l]] = [$original[$l], $original[$k]];

        // Меняем местами элементы с индексами $k + 1 ... $length - 1
        $lo = $k + 1;
        $hi = $length - 1;
        while ($lo < $hi) {
            [$original[$lo], $original[$hi]] = [$original[$hi], $original[$lo]];
            $lo++;
            $hi--;
        }

        return $original;
    }
}
