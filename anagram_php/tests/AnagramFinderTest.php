<?php

namespace App;

use PHPUnit\Framework\TestCase;

class AnagramFinderTest extends TestCase {

    public function testGroupAnagramsInArray() {
        $expected = [
            ["listen", "silent"],
            ["listen", "tinsel"],
            ["silent", "tinsel"]
        ];

        $input = ["listen", "silent", "google", "silent", "tinsel"];

        $output = (new AnagramFinder())->groupAnagrams($input);

        $this->assertEquals($expected, $output);
    }

}