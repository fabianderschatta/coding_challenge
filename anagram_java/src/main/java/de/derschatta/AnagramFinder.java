package de.derschatta;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;
import java.util.InputMismatchException;

import org.jetbrains.annotations.Nullable;

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
public class AnagramFinder {

    /**
     * Takes an array of words and returns an array of arrays, where each inner array
     * contains words that are anagrams of each other. 
     */
    public @Nullable List<List<String>> groupAnagrams(List<String> words) {
        if (words.isEmpty()) {
            return null;
        }
        
        validateWords(words);

        List<List<String>> groupedAnagrams = new ArrayList<>();

        for (String subject : words) {
            // Skip empty strings
            if (subject.trim().isEmpty()) continue;
            
            for (String word : words) {
                if (isWordAnAnagramOfSubject(word, subject)
                    && !groupExists(subject, word, groupedAnagrams)    
                ) {
                    groupedAnagrams.add(new ArrayList<>(Arrays.asList(subject, word)));
                }
            }
        }

        if (groupedAnagrams.isEmpty()) {
            return null;
        }

        return groupedAnagrams;
    }

    /**
     * Make sure we have only valid words in the array we can form anagrams for.
     * 
     * We only accept string with alphanumeric characters.
     */
    private void validateWords(List<String> words) {
        for (String word : words) {
            // We just ignore empty strings
            if (word.trim().isEmpty()) continue;

            if (!word.matches("^[a-zA-Z0-9]*$")) {
                throw new InputMismatchException("Word " + word + " contains illegal character. Only alphanumeric characters allowed.");
            }
        }
    }

    /**
     * Check if the given word is an anagram of the subject.
     */
    private boolean isWordAnAnagramOfSubject(String word, String subject) {
        // Same words are not anagrams
        if (word.equals(subject) || word.trim().isEmpty()) {
            return false;
        }

        // Split the word and for each character found in the subject
        // remove it from the list
        String[] splitSubject = subject.split("");
        ArrayList<String> splitMatch = new ArrayList<>(Arrays.asList(word.split("")));

        for (String character : splitSubject) {
            int indexOfList = splitMatch.indexOf(character); 
            if (indexOfList > -1) {
                splitMatch.remove(indexOfList);
            }
        }

        // Empty means all characters of the subject are present
        return splitMatch.isEmpty();
    }

    /**
     * Check if the given combination already exists in the given groups array.
     */
    private boolean groupExists(String subject, String match, List<List<String>> groups) {
        ArrayList<String> newGroup = new ArrayList<>(Arrays.asList(subject, match));
        ArrayList<String> reverseGroup = new ArrayList<>(newGroup.reversed());

        return groups.contains(newGroup) || groups.contains(reverseGroup);
    }
}
