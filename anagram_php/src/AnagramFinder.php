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
            foreach ($words as $match) {
                if ($this->isWordAnAnagramOfSubject($match, $subject)
                    && !$this->groupExists($subject, $match, $groupedAnagrams)    
                ) {
                    $groupedAnagrams[] = [$subject, $match];
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

    /**
     * Check if the given word is an anagram of the subject.
     */
    private function isWordAnAnagramOfSubject(string $word, string $subject): bool
    {
        // Same words are not anagrams
        if ($word === $subject) {
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

            // If we found the character remove it from the match
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
    private function groupExists(string $subject, string $match, array $groups): bool {
        $group = [$subject, $match];
        $reverseGroup = array_reverse($group);

        return in_array($group, $groups) || in_array($reverseGroup, $groups);
    }

}