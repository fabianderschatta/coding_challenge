<?php

namespace App;

use PHPUnit\Framework\TestCase;

class AnagramFinderTest extends TestCase 
{

    private AnagramFinder $anagramFinder;

    protected function setUp(): void
    {
        $this->anagramFinder = new AnagramFinder();
    }

    public function testGroupAnagramsInArray() 
    {
        $expected = [
            ["listen", "silent"],
            ["listen", "tinsel"],
            ["silent", "tinsel"]
        ];
        $input = ["listen", "silent", "google", "silent", "tinsel"];

        $output = $this->anagramFinder->groupAnagrams($input);

        $this->assertEqualsCanonicalizing($expected, $output);
    }

    public function testEmptyListPassedReturnsEmptyArray() 
    {
        $expected = [];
        $input = [];

        $output = $this->anagramFinder->groupAnagrams($input);

        $this->assertEquals($expected, $output);
    }

    public function testNoAnagramMatchesAreNotReturned() 
    {
        $expected = [];
        $input = ["google", "google"];

        $output = $this->anagramFinder->groupAnagrams($input);

        $this->assertEquals($expected, $output);
    }

    public function testInvalidCharactersInWordsThrowException() 
    {
        $input = ["g@@gle", "google"];

        $this->expectException(IllegalCharacterException::class);
        $this->anagramFinder->groupAnagrams($input);
    }

    public function testAnythingOtherThanStringsThrowsException() 
    {
        $input = [10, "silent", "listen"];

        $this->expectException(IllegalCharacterException::class);
        $this->anagramFinder->groupAnagrams($input);
    }

}