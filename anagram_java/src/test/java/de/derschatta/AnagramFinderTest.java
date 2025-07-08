package de.derschatta;

import static org.assertj.core.api.Assertions.assertThat;
import static org.junit.Assert.assertNull;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.InputMismatchException;
import java.util.List;

import org.junit.Before;
import org.junit.Test;

/**
 * Unit test for anagram finder coding challenge.
 */
public class AnagramFinderTest {

    private AnagramFinder anagramFinder;
     
    @Before
    public void setUp() {
        anagramFinder = new AnagramFinder();
    }

    @Test
    public void groupAnagramsInArray() {
        List<List<String>> expected = Arrays.asList(
            Arrays.asList("listen", "silent"),
            Arrays.asList("listen", "tinsel"),
            Arrays.asList("silent", "tinsel")
        );

        List<String> input = Arrays.asList(
        "listen", 
            "silent",
            "google",
            "",
            "silent", 
            " ",
            "tinsel"
        );

        List<List<String>> result = anagramFinder.groupAnagrams(input);

        assertThat(result).hasSameElementsAs(expected);
    }

    @Test
    public void sameWordsAreIgnoredAndNoEmptyInnerListsCreated() {
        List<String> input = Arrays.asList(
        "listen", 
            "listen"
        );

        assertNull(anagramFinder.groupAnagrams(input));
    }

    @Test
    public void emptyListPassedReturnsEmptyArray() {
        List<String> input = new ArrayList<>();

        assertNull(anagramFinder.groupAnagrams(input));
    }

    @Test
    public void nonAnagramMatchesAreNotReturned() {
        List<String> input = Arrays.asList(
        "google", 
            "microsoft"
        );

        assertNull(anagramFinder.groupAnagrams(input));
    }

    @Test(expected=InputMismatchException.class)
    public void invalidCharactersInWordsThrowException() {
        List<String> input = Arrays.asList(
        "g@@gle", 
            "google"
        );

        anagramFinder.groupAnagrams(input);
    }

}
