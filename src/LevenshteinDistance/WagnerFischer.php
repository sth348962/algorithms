<?php

declare(strict_types=1);

namespace Sth348962\Algorithms\LevenshteinDistance;

class WagnerFischer
{
    /**
     * @param string $from Из какой строки
     * @param string $to   В какую строку
     *
     * @return int[][] Матрица дистанций
     */
    public function matrix(string $from, string $to): array
    {
        $m = strlen($from);
        $n = strlen($to);

        // Крайний случай - если одна из строк (или обе) равна нулю
        if (0 === $n + $m) {
            return [];
        }

        if (0 === $n) {
            return array_map(function (int $value) {
                return [$value];
            }, range(0, $m, 1));
        }

        if (0 === $m) {
            return [range(0, $n, 1)];
        }

        /**
         * @var int[][] Матрица расстояний
         *
         * Считаем, что $i индекс соответствует $i - 1 символу в строке $from,
         * а $j индекс соответствует $j - 1 символу в строке $to,
         * т. е. 0 - сравнение с пустой строкой.
         *
         *             T       O
         *           j - 1     j     j + 1
         *  F i - 1 [  A  ] [  B  ] [ ... ]
         *  R i     [  C  ] [  D  ] [ ... ]
         *  O i + 1 [ ... ] [ ... ] [ ... ]
         *  M i + 2 [ ... ] [ ... ] [ ... ]
         *
         * Если
         *  D == C + 1, то происходит добавление символа
         *  D == B + 1, то происходит удаление символа
         *  D == A + 1, то происходит замена символа
         *  D == A, то символы совпадают
         */
        $matrix = [];

        for ($i = 0; $i <= $m; $i++) {
            for ($j = 0; $j <= $n; $j++) {
                if (0 === $i || 0 === $j) {
                    // Расчет сравнения с пустой строкой
                    $matrix[$i][$j] = $i + $j;

                    continue;
                }

                if ($to[$j - 1] === $from[$i - 1]) {
                    $matrix[$i][$j] = $matrix[$i - 1][$j - 1];
                } else {
                    // Из массивов предыдущих значений выбираем минимальные
                    $matrix[$i][$j] = min(
                        $matrix[$i - 1][$j] + 1,
                        $matrix[$i][$j - 1] + 1,
                        $matrix[$i - 1][$j - 1] + 1
                    );
                }
            }
        }

        // Так как нумерация символов начиналась с первого элемента
        return $matrix;
    }
}
