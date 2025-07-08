<?php
declare(strict_types=1);

namespace App;

use App\Exception\IllegalCharacterException;

/**
 * A class to find anagrams.
 * 
 * This is part of the following coding challenge:
 * 
 * Write a class AnagramFinder with a function groupAnagrams that takes an array of words and returns an array
 * of arrays, where each inner array contains words that are anagrams of each other. Each group of anagrams
 * should be listed together in the inner array.
 * 
 * An anagram of a word is a word formed by rearranging the letters of the original, using all the original
 * letters exactly once. For example:
 *   • "listen" is an anagram of "silent".
 *   • "evil" is an anagram of "vile".
 * 
 * Input:
 *   • wordList: A list of strings, where each string is a word (e.g., ["listen", "silent", "google", "silent", "tinsel"]).
 * Output:
 *   • A list of lists, where each inner list contains all the words from wordList that are anagrams of each
 *     other. Words within each inner list should be in any order, but anagram groups must be distinct.
 *   • Provided words without at least one anagram should get dropped.
 *   • No empty inner lists
 */
class AnagramFinder
{

    /**
     * Takes an array of words and returns an array of arrays, where each inner array
     * contains words that are anagrams of each other. 
     */
    public function groupAnagrams(array $words): array
    {
        // Just return empty array if nothging given
        if (empty($words)) {
            return [];
        }

        // Validate all words
        $this->validateWords($words);

        $groupedAnagrams = [];

        foreach ($words as $subject) {
            $splittedSubject = str_split($subject);

            foreach ($words as $match) {
                // Ignore the same word
                if ($match == $subject) {
                    continue;
                }

                // Split the word and for each character found in the subject
                // remove it from the list
                $splittedMatch = str_split($match);
                foreach ($splittedSubject as $char) {
                    $keyInArray = array_find_key($splittedMatch, function(string $value) use ($char) {
                        return $value === $char;
                    });

                    // If we found the character remove it from the match
                    if ($keyInArray !== null) {
                        unset ($splittedMatch[$keyInArray]);
                    }
                }

                // Empty means all characters of the subject are present
                if (empty($splittedMatch)) {
                    $group = [$subject, $match];
                    $reverseGroup = [$match, $subject];

                    if (!in_array($group, $groupedAnagrams) 
                        && !in_array($reverseGroup, $groupedAnagrams)
                    ) {
                        $groupedAnagrams[] = [$subject, $match];
                    }
                }
            }
        }
        
        return $groupedAnagrams;
    }

    private function validateWords(array $words): void {
        array_walk($words, function($word) {
            if (!is_string($word)) {
                throw new IllegalCharacterException("Word $word is not a string.");
            }
            if (preg_match('/[^a-z0-9]/i', $word)) {
                throw new IllegalCharacterException("Word $word contains illegal character. Only alphanumeric characters allowed.");
            }
        });
    }

}