package de.derschatta;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.InputMismatchException;
import java.util.List;

import static org.assertj.core.api.Assertions.assertThat;
import static org.junit.Assert.assertNull;
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
            Arrays.asList("listen", "silent", "tinsel"),
            Arrays.asList("vile", "evil")
        );

        List<String> input = Arrays.asList(
            "listen", 
            "silent", 
            "",
            "google", 
            "evil",
            "silent",
            "vile", 
            " ",
            "tinsel",
            "evil"
        );

        List<List<String>> result = anagramFinder.groupAnagrams(input);

        assertThat(result).usingRecursiveComparison().ignoringCollectionOrder().isEqualTo(expected);
    }

    @Test
    public void groupingIsCaseSensitive() {
        List<List<String>> expected = Arrays.asList(
            Arrays.asList("listen", "silent")
        );

        List<String> input = Arrays.asList(
            "listen", 
            "silent", 
            "Anna",
            "nana"
        );

        List<List<String>> result = anagramFinder.groupAnagrams(input);

        assertThat(result).usingRecursiveComparison().ignoringCollectionOrder().isEqualTo(expected);
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
