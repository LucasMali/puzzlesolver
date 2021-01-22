<?php
namespace Tests;

use App\Puzzle as AppPuzzle;
use PHPUnit\Framework\TestCase;

class PuzzleTest extends TestCase{
    public $puzzle;

    public function testThis()
    {
        $this->puzzle = new AppPuzzle([1,2,3,4,5,6,7]);
        $this->puzzle->left();
        $this->assertSame($this->puzzle->current, [2,3,4,5,6,7,1]);
    }

}