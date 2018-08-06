<?php

namespace Sth348962\Algorithms\ClosestPair;

use RuntimeException;

class Space2D
{
    /**
     * @var callable Функция сравнения по координате x
     */
    protected $compareByX;

    /**
     * @var callable Функция сравнения по координате y
     */
    protected $compareByY;

    /**
     * @var callable Функция сортировки массива по координате x
     */
    protected $sortByX;

    /**
     * @var callable Функция сортировки массива по координате y
     */
    protected $sortByY;

    /**
     * @var callable Функция для объединения сортированных массивов по координате y
     */
    protected $mergeByY;

    /**
     * @var callable Функция, вычисляющая дистанцию между двумя точками
     */
    protected $measure;

    /**
     * @var callable Функция, вычисляющая дистанцию между двумя точками по координате x
     */
    protected $measureByX;

    /**
     * @var callable Функция, вычисляющая дистанцию между двумя точками по координате y
     */
    protected $measureByY;

    public function __construct(callable $compareByX, callable $compareByY, callable $sortByX, callable $sortByY, callable $mergeByY, callable $measure, callable $measureByX, callable $measureByY)
    {
        $this->compareByX = $compareByX;
        $this->compareByY = $compareByY;
        $this->sortByX = $sortByX;
        $this->sortByY = $sortByY;
        $this->mergeByY = $mergeByY;
        $this->measure = $measure;
        $this->measureByX = $measureByX;
        $this->measureByY = $measureByY;
    }

    /**
     * Поиск ближайших пар в несортированном массивее.
     *
     * @param mixed[] $points Массив точек
     * @return mixed[][] Точки с минимальным расстоянием
     */
    public function find(array $points): array
    {
        $sortedPoints = call_user_func($this->sortByX, $points);
        $stepResult = $this->findInSortedArray($sortedPoints);
        return $stepResult->getClosestPoints();
    }

    /**
     * Поиск ближайших пар в сортированном массивее.
     *
     * @param mixed[] $points Отсортированный по X массив точек
     * @return \Sth348962\Algorithms\ClosestPair\StepResult Промежуточное значение
     * @throws \RuntimeException
     */
    protected function findInSortedArray(array $points): StepResult
    {
        $length = count($points);
        if ($length < 4) {
            return $this->findBruteForce($points);
        }

        $mid = ceil($length / 2);
        [$left, $right] = array_chunk($points, $mid);

        // Вычисляем значения отдельно для каждой половины
        $leftStep = $this->findInSortedArray($left);
        $rightStep = $this->findInSortedArray($right);

        // Получаем минимальное расстояние и массив ближайших точек
        $minDistance = min($leftStep->getDistance(), $rightStep->getDistance());
        if ($leftStep->getDistance() === $minDistance) {
            $closestPairs = $leftStep->getClosestPoints();
            if ($rightStep->getDistance() === $minDistance) {
                $closestPairs = array_merge($closestPairs, $rightStep->getClosestPoints());
            }
        } else {
            $closestPairs = $rightStep->getClosestPoints();
        }

        // Получаем точки, отсортированные по координате y
        $pointsSortedByY = call_user_func($this->mergeByY, $leftStep->getPointsSortedByY(), $rightStep->getPointsSortedByY());

        // Получаем точки, которые могут быть в ближайшей паре
        $midPoint = $points[$mid - 1];
        $strip = [];
        foreach ($pointsSortedByY as $point) {
            if (call_user_func($this->measureByX, $midPoint, $point) <= $minDistance) {
                $strip[] = $point;
            }
        }

        // Проходим по массиву точек в поисках нового минимума
        $stripLength = count($strip);
        for ($i = 0; $i < $stripLength; $i++) {
            $pointA = $strip[$i];
            for ($j = $i + 1; $j < $stripLength; $j++) {
                $pointB = $strip[$j];

                // Точки находятся в левой или в правой половине
                $pointAPosition = call_user_func($this->compareByX, $pointA, $midPoint);
                $pointBPosition = call_user_func($this->compareByX, $pointB, $midPoint);
                if ($pointAPosition === $pointBPosition || $pointAPosition === 0 || $pointBPosition === 0) {
                    // Точки с координатой x, равной точке $midPoint, могут находиться как в правой,
                    // так и в левой половине
                    if ($pointAPosition === 0) {
                        if ($pointA === $midPoint) {
                            // Центральная точка принадлежит левой половине
                            $pointAPosition = -1;
                        } else {
                            $pointAPosition = call_user_func($this->compareByY, $pointA, $midPoint);
                        }
                    }

                    if ($pointBPosition === 0) {
                        if ($pointB === $midPoint) {
                            // Центральная точка принадлежит левой половине
                            $pointBPosition = -1;
                        } else {
                            $pointBPosition = call_user_func($this->compareByY, $pointB, $midPoint);
                        }
                    }

                    if ($pointAPosition === $pointBPosition) {
                        // Если точки находятся в одной половине - проверять нечего
                        continue;
                    }
                }

                if (call_user_func($this->measureByY, $pointA, $pointB) > $minDistance) {
                    // Если вышли за пределы возможных минимальных пар
                    break;
                }

                $currentDistance = call_user_func($this->measure, $pointA, $pointB);
                if ($currentDistance < $minDistance) {
                    // Если у нас новое минимальное расстояние
                    $closestPairs = [];
                    $minDistance = $currentDistance;
                    // Сами точки добавим в массив ниже
                }

                if ($currentDistance === $minDistance) {
                    // Добавляем новую пару точек
                    $closestPairs[] = [$pointA, $pointB];
                }
            }
        }

        return new StepResult($minDistance, $closestPairs, $pointsSortedByY);
    }

    /**
     * Поиск ближайших пар в несортированном массивее методом brute force.
     *
     * @param mixed[] $points Массив точек
     * @return \Sth348962\Algorithms\ClosestPair\StepResult Промежуточное значение
     * @throws \RuntimeException
     */
    protected function findBruteForce(array $points): StepResult
    {
        $length = count($points);
        if ($length < 2) {
            // Невозможно посчитать минимальное расстояние для массивов нулевой или единичной длины
            throw new RuntimeException('Unreachable code');
        }

        $minDistance = PHP_FLOAT_MAX;
        for ($i = 0; $i < $length; $i++) {
            for ($j = $i + 1; $j < $length; $j++) {
                $tmp = call_user_func($this->measure, $points[$i], $points[$j]);
                if ($minDistance < $tmp) {
                    continue;
                }
                if ($minDistance > $tmp) {
                    // Будет вызван минимум один раз, т.к. $minDistance = PHP_FLOAT_MAX
                    $closestPairs = [];
                }
                $minDistance = $tmp;
                $closestPairs[] = [$points[$i], $points[$j]];
            }
        }

        // Сортируем массив по координате y
        $pointsSortedByY = call_user_func($this->sortByY, $points);

        return new StepResult($minDistance, $closestPairs, $pointsSortedByY);
    }
}