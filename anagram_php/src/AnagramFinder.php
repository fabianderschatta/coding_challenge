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
        if (empty($words)) {
            return [];
        }

        // Validate all words
        $this->validateWords($words);

        $groupedAnagrams = [];
        while (!empty($words)) {
            // Get and remove the first word from the array
            $subject = array_shift($words);

            // Ignore empty strings
            if (empty(trim($subject))) continue;

            foreach ($words as $word) {
                $group = $this->createGroup($subject, $word);
                if ($this->isWordAnAnagramOfSubject($word, $subject)
                    && !$this->groupExists($group, $groupedAnagrams)
                ) {
                    $groupedAnagrams[] = $group;
                }
            }
        }
        
        return $groupedAnagrams;
    }

    /**
     * Make sure we have only valid words in the array we can form anagrams for.
     * 
     * We only accept string with alphanumeric characters.
     */
    private function validateWords(array $words): void 
    {
        array_walk($words, function($word) {
            if (!is_string($word)) {
                throw new IllegalCharacterException("Word $word is not a string.");
            }
            if (!preg_match('/^[a-zA-Z0-9]*$/', trim($word))) {
                throw new IllegalCharacterException("Word $word contains illegal character. Only alphanumeric characters allowed.");
            }
        });
    }

    /**
     * Creates a sorted array containing subject and word
     */
    private function createGroup(string $subject, string $word): array 
    {
        $group = [$subject, $word];
        sort($group);
        return $group;
    }

    /**
     * Check if the given word is an anagram of the subject.
     */
    private function isWordAnAnagramOfSubject(string $word, string $subject): bool
    {
        // Same words are not anagrams and ignore empty strings
        if ($word === $subject || empty(trim($word))) {
            return false;
        }

        // Split the word and for each character found in the subject
        // remove it from the list
        $splitSubject = str_split($subject);
        $splitMatch = str_split($word);
        foreach ($splitSubject as $char) {
            $keyInArray = array_find_key($splitMatch, function(string $value) use ($char) {
                return $value === $char;
            });

            if ($keyInArray !== null) {
                unset ($splitMatch[$keyInArray]);
            }
        }

        // Empty means all characters of the subject are present
        return empty($splitMatch);
    }

    /**
     * Check if the given combination already exists in the given groups array.
     */
    private function groupExists(array $group, array $groups): bool 
    {
        return in_array($group, $groups);
    }

}