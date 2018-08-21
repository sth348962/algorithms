<?php

declare(strict_types=1);

namespace Sth348962\Algorithms\KnuthMorrisPratt;

class KnuthMorrisPratt
{
    /**
     * @param string $text   Текст, в котором ведется поиск
     * @param string $sample Искомая строка
     * @param int[]  $p      Префикс-функция от искомой строки
     *
     * @return int[] Массив позиций
     */
    public function positions(string $text, string $sample, array $p): array
    {
        $n = strlen($text);
        $m = strlen($sample);

        $positions = [];

        if ($n === 0 || $m === 0) {
            // Если одна из строк нулевой длины - искать нечего
            return $positions;
        }

        for ($i = 0, $j = 0; $i < $n; $i++) {
            if ($text[$i] !== $sample[$j] && $j > 0) {
                // Если символы не совпали - пытаемся найти лучшую позицию, с которой сможем продолжить поиск
                $j = $p[$j - 1];
            }

            if ($text[$i] === $sample[$j]) {
                // Если символы совпали - перемещаемся на следующую позицию в искомой строке
                $j++;
            }

            if ($j === $m) {
                // Если подстрока найдена - записываем её в результирующий массив
                $positions[] = $i - $m + 1;

                // После чего перемещаемся на позицию после префикса искомой строки,
                // чтобы правильно обрабатывать ситуации поиска подстроки abcabc в
                // тексте abcabcabc
                $j = $p[$j - 1];
            }
        }

        return $positions;
    }
}
