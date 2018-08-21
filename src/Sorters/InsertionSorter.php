<?php

declare(strict_types=1);

namespace Sth348962\Algorithms\Sorters;

use RuntimeException;

class InsertionSorter extends Sorter
{
    /**
     * Возвращает новый отсортированный массив из элементов переданного.
     *
     * @param mixed[] $original
     *
     * @return mixed[]
     */
    public function sort(array $original): array
    {
        $sorted = $original;
        if (!$this->sortM($sorted)) {
            throw new RuntimeException('Unreachable code');
        }

        return $sorted;
    }

    public function sortM(array &$original): bool
    {
        $length = count($original);

        for ($i = 1; $i < $length; $i++) {
            $current = $original[$i];
            $j = $i - 1;
            while ($j >= 0 && call_user_func($this->sortFn, $original[$j], $current) > 0) {
                $original[$j + 1] = $original[$j];
                $j--;
            }
            if ($i !== $j + 1) {
                // Если позиция текущего элемента изменилась
                $original[$j + 1] = $current;
            }
        }

        return true;
    }
}
