<?php

namespace App\Tests\Util;

/**
 * Thanks ChatGPT!
 */
class RandomAnagramListGenerator
{

    public function generateWordList($total = 1000, $anagramRatio = 0.5)
    {
        $seedWords = [
            "planet", "listen", "evil", "dust", "night", "angel", "state",
            "forest", "laptop", "silver", "rocket", "castle", "hunter", "mirror",
            "needle", "object", "ticket", "pillow", "rabbit", "school", "coffee",
            "banana", "guitar", "window", "orange", "cloud", "wallet", "violin",
            "lamp", "jacket", "spoon", "turtle", "unicorn", "keyboard", "quartz"
        ];

        $wordList = [];

        $anagramCount = intval($total * $anagramRatio);
        $nonAnagramCount = $total - $anagramCount;

        // Generate anagram entries
        while (count($wordList) < $anagramCount) {
            $base = $seedWords[array_rand($seedWords)];
            $chars = str_split($base);
            shuffle($chars);
            $shuffled = implode('', $chars);

            if ($shuffled !== $base) {
                $wordList[] = $shuffled;
            }
        }

        // Add original (non-anagram) words
        while (count($wordList) < $total) {
            $wordList[] = $seedWords[array_rand($seedWords)];
        }

        // Shuffle final list
        shuffle($wordList);

        return $wordList;
    }

}