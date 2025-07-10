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

        $this->validateWords($words);

        $groupedAnagrams = [];

        // TODO: Refactor this using a more efficient logic as execution time does grow quadratically 
        while (!empty($words)) {
            // Get and remove the first word from the array
            // to not have to go through all words again from the start
            $subject = array_shift($words);

            // Ignore empty strings
            if (empty(trim($subject))) continue;

            $currentGroup = [$subject];

            foreach ($words as $index => $word) {
                if ($this->isWordAnAnagramOfSubject($word, $subject)) {
                    $currentGroup[] = $word;
                    // It's already part of a group so remove it to save time later
                    unset($words[$index]);
                }
            }

            if (!empty($currentGroup)) {
                $groupedAnagrams[] = $currentGroup;
            }
        }

        return $this->cleanUpGroups($groupedAnagrams);
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
     * Check if the given word is an anagram of the subject.
     */
    private function isWordAnAnagramOfSubject(string $word, string $subject): bool
    {
        // Make sure we exit early to save time
        if ($word === $subject 
            || empty(trim($word)) 
            || strlen($word) != strlen($subject)
        ) {
            return false;
        }

        $splitSubject = str_split($subject);
        sort($splitSubject);
        $splitMatch = str_split($word);
        sort($splitMatch);

        return $splitMatch == $splitSubject;
    }

    /**
     * Clean up groups, making sure in each group each word only exists once
     */
    private function cleanUpGroups(array $groupedAnagrams): array
    {
        $cleanedGroupedAnagrams = [];
        foreach ($groupedAnagrams as $group) {
            $group = array_unique($group);
            if (count($group) > 1) {
                $cleanedGroupedAnagrams[] = $group;
            }           
        }
        
        return $cleanedGroupedAnagrams;
    }

}