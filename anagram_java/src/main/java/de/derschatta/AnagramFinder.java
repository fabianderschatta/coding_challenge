package de.derschatta;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.Comparator;
import java.util.HashSet;
import java.util.InputMismatchException;
import java.util.List;

import org.jetbrains.annotations.Nullable;

/**
 * A class to find anagrams.
 * 
 * This is part of the following coding challenge:
 * 
 * Write a class AnagramFinder with a function groupAnagrams that takes a lisst of words and returns a list
 * of lists, where each inner list contains words that are anagrams of each other. Each group of anagrams
 * should be listed together in the inner list.
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
     * Takes a list of words and returns a list of lists, where each inner list
     * contains words that are anagrams of each other. 
     */
    public @Nullable List<List<String>> groupAnagrams(List<String> words) {
        if (words.isEmpty()) {
            return null;
        }
        
        validateWords(words);

        ArrayList<String> mutableWordList = new ArrayList<>(words);
        List<List<String>> groupedAnagrams = new ArrayList<>();

        while(!mutableWordList.isEmpty()) {
            // Get and remove the first word from the list
            // to not have to go through the whole list on every iteration again
            String subject = mutableWordList.get(0);
            mutableWordList.remove(0);

            // Skip empty strings
            if (subject.trim().isEmpty()) continue;

            List<String> currentList = new ArrayList<>();
            currentList.add(subject);
            
            for (int i = 0; i < mutableWordList.size(); i++) {
                String word = mutableWordList.get(i);
                if (isWordAnAnagramOfSubject(word, subject)) {
                    currentList.add(word);
                    // It's already part of a group so remove it to save time later
                    mutableWordList.remove(i);
                }
            }

            if (!currentList.isEmpty()) {
                groupedAnagrams.add(currentList);
            }
        }

        List<List<String>> finalGroupedList = cleanUpGroups(groupedAnagrams);

        return !finalGroupedList.isEmpty() ? finalGroupedList : null;
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
        // Exit as early as possible to save time
        if (word.equals(subject) 
            || word.trim().isEmpty()
            || word.length() != subject.length()
        ) {
            return false;
        }

        // Let's split the words into its characters
        // and determine whether they include the same letters
        String[] splitSubject = subject.split("");
        String[] splitMatch = word.split("");

        Comparator<String> comparator = (string1, string2) -> {
            return string1.compareTo(string2);
        };

        Arrays.sort(splitSubject, comparator);
        Arrays.sort(splitMatch, comparator);

        return Arrays.compare(splitSubject, splitMatch) == 0;
    }

    /**
     * Clean up groups, making sure in each group each word only exists once
     */
    private List<List<String>> cleanUpGroups(List<List<String>> groupedAnagrams) {
        List<List<String>> finalGroupedList = new ArrayList<>();

        for (List<String> group: groupedAnagrams) {
            List<String> uniqueGroup = new ArrayList<>(new HashSet<>(group));

            if (uniqueGroup.size() > 1) {
                finalGroupedList.add(uniqueGroup);
            }
        }

        return finalGroupedList;
    }
}
