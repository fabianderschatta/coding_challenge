package de.derschatta;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.InputMismatchException;
import java.util.List;

import static org.assertj.core.api.Assertions.assertThat;
import org.junit.Test;

/**
 * Unit test for anagram finder coding challenge.
 */
public class AnagramFinderTest {

    @Test(expected=InputMismatchException.class)
    public void throwsExceptionWhenEmptyListGiven() {
        List<String> words = new ArrayList<>();

        AnagramFinder anagramFinder = new AnagramFinder();
        anagramFinder.groupAnagrams(words);
    }

    @Test
    public void findsAnagramsInList() {
        List<String> words = new ArrayList<>(
            Arrays.asList(
            "listen", 
                "silent",
                "google", 
                "silent", 
                "tinsel"
            )
        );

        AnagramFinder anagramFinder = new AnagramFinder();
        List<List<String>> result = anagramFinder.groupAnagrams(words);

        List<List<String>> expected = Arrays.asList(
            Arrays.asList("listen", "silent"),
            Arrays.asList("listen", "tinsel"),
            Arrays.asList("silent", "tinsel")
        );

        assertThat(result).hasSameElementsAs(expected);
    }
}
