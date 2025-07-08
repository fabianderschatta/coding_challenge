# Anagram finder

## Problem Statement:
Write a class AnagramFinder with a function groupAnagrams that takes a list of words and returns a list
of lists, where each inner list contains words that are anagrams of each other. Each group of anagrams
should be listed together in the inner list.

An anagram of a word is a word formed by rearranging the letters of the original, using all the original
letters exactly once. For example:
* "listen" is an anagram of "silent".
* "evil" is an anagram of "vile".

## Signature:
Here’s an example signature of such a function in Kotlin:

```kotlin
fun groupAnagrams(wordList: List<String>): List<List<String>>
```
… and in Java:

```java
public List<List<String>> groupAnagrams(List<String> wordList)
```

### Input:
* wordList: A list of strings, where each string is a word (e.g., `["listen", "silent", "google", "silent", "tinsel"]`).
### Output:
* A list of lists, where each inner list contains all the words from wordList that are anagrams of each
other. Words within each inner list should be in any order, but anagram groups must be distinct.
* Provided words without at least one anagram should get dropped.
* No empty inner lists.

## Template code
### in Kotlin:

```kotlin
package com.pcs.development.challenge.anagrams

class AnagramFinder {
    fun groupAnagrams(words: List<String>): List<List<String>> {
        // TODO
    }
}
```

### in Java:

```java
package com.pcs.development.challenge.anagrams;

import java.util.*;

public class AnagramFinder {
    public List<List<String>> groupAnagrams(List<String> words) {
        // TODO
    }
}
```