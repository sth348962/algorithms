<?php

declare(strict_types=1);

namespace Sth348962\Algorithms\LevenshteinDistance;

use Sth348962\Algorithms\LevenshteinDistance\Backtrace\Step;
use Tree\Node\Node;

class Backtrace
{
    /**
     * @param string  $from   Из какой строки
     * @param string  $to     В какую строку
     * @param int[][] $matrix Матрица расстояний
     *
     * @return \Tree\Node\Node Корневой узел дерева всевозможных оптимальных правок
     */
    public function root(string $from, string $to, array $matrix): Node
    {
        $m = strlen($from);
        $n = strlen($to);

        // Вершина дерева правок
        $root = new Node(Step::root());

        // Крайний случай - если одна из строк (или обе) нулевой длины
        if (0 === $n + $m) {
            return $root;
        }

        // Если нужно получить пустую строку
        if (0 === $n) {
            $parent = $root;
            $i = $m;
            while ($i > 0) {
                $i--;
                $node = new Node(Step::delete($from[$i], 0, $i + 1));
                $parent->addChild($node);
            }

            return $root;
        }

        // Если дана пустая строка
        if (0 === $m) {
            $parent = $root;
            $j = $n;
            while ($j > 0) {
                $j--;
                $node = new Node(Step::insert($to[$j], $j + 1, 0));
                $parent->addChild($node);
            }

            return $root;
        }

        // Получаем все возможные оптимальные пути
        $stack = [['parent' => $root, 'i' => $m - 1, 'j' => $n - 1]];
        while (count($stack) > 0) {
            $step = array_pop($stack);
            $parent = $step['parent'];
            $i = $step['i'];
            $j = $step['j'];

            // Текущее число редакционных правок
            $currentValue = $matrix[$i + 1][$j + 1] ?? null;

            // Предыдущие значения
            $upperLeftValue = $matrix[$i][$j] ?? null;
            $upperValue = $matrix[$i][$j + 1] ?? null;
            $leftValue = $matrix[$i + 1][$j] ?? null;

            // Находим минимальное значение
            $values = [];
            if (null !== $upperLeftValue) {
                $values[] = $upperLeftValue;
            }
            if (null !== $upperValue) {
                $values[] = $upperValue;
            }
            if (null !== $leftValue) {
                $values[] = $leftValue;
            }
            if (empty($values)) {
                // Если элементов не осталось - смотрим другие варианты
                continue;
            }
            $min = min($values);

            if (null !== $upperLeftValue && $min === $upperLeftValue) {
                // Если идем по диагонали
                if ($upperLeftValue === $currentValue) {
                    // Если правок не было
                    $node = new Node(Step::match($from[$i], $j + 1, $i + 1));
                    $parent->addChild($node);
                } else {
                    // Если была замена символа
                    $node = new Node(Step::replace($from[$i], $to[$j], $j + 1, $i + 1));
                    $parent->addChild($node);
                }

                // Идем по диагонали
                $stack[] = ['parent' => $node, 'i' => $i - 1, 'j' => $j - 1];
            }

            if (null !== $upperValue && $min === $upperValue) {
                // Если было удаление символа
                $node = new Node(Step::delete($from[$i], $j + 1, $i + 1));
                $parent->addChild($node);

                // Поднимаемся
                $stack[] = ['parent' => $node, 'i' => $i - 1, 'j' => $j];
            }

            if (null !== $leftValue && $min === $leftValue) {
                // Если было добавление символа
                $node = new Node(Step::insert($to[$j], $j + 1, $i + 1));
                $parent->addChild($node);

                // Идем влево
                $stack[] = ['parent' => $node, 'i' => $i, 'j' => $j - 1];
            }
        }

        // Возвращаем корневой элемент
        return $root;
    }
}
