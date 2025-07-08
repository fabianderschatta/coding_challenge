<?php
declare(strict_types=1);

namespace App\Tests;

use App\AnagramFinder;
use App\Exception\IllegalCharacterException;
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
        $input = [
            "listen", 
            "silent", 
            "",
            "google", 
            "silent", 
            " ",
            "tinsel"
        ];

        $output = $this->anagramFinder->groupAnagrams($input);

        $this->assertEqualsCanonicalizing($expected, $output);
    }

    public function testSameWordsAreIgnored() 
    {
        $expected = [];
        $input = ["listen", "listen"];

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
        $input = ["google", "microsoft"];

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