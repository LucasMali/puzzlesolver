<?php
namespace Tests;

use App\Puzzle as AppPuzzle;
use PHPUnit\Framework\TestCase;

/**
 * PuzzleSolverTest class
 */
class PuzzleTest extends TestCase{

    public AppPuzzle $puzzle;

    public function testShiftLeft(): void
    {
        $this->puzzle = new AppPuzzle([1,2,3,4,5,6,7]);
        $this->puzzle->left();

        $expected = (new AppPuzzle([2,3,4,5,6,7,1]))->current->serialize();
        $actual = $this->puzzle->current->serialize();

        $this->assertEquals($expected, $actual);
    }

    public function testShiftRight(): void
    {
        $this->puzzle = new AppPuzzle([1,2,3,4,5,6,7]);
        $this->puzzle->right();

        $expected = (new AppPuzzle([7,1,2,3,4,5,6]))->current->serialize();
        $actual = $this->puzzle->current->serialize();

        $this->assertEquals($expected, $actual);
    }

    public function testMiddleSwap(): void
    {
        $this->puzzle = new AppPuzzle([1,2,3,4,5,6,7]);
        $this->puzzle->middle();

        $expected = (new AppPuzzle([1,2,5,4,3,6,7]))->current->serialize();
        $actual = $this->puzzle->current->serialize();

        $this->assertEquals($expected, $actual);
    }

    public function testIsSolvedPass(): void
    {
        $this->puzzle = new AppPuzzle([1,2,3,4,5,6,7]);
        $actual = $this->puzzle->isSolved();
        $this->assertTrue($actual);
    }

    public function testIsSolvedFail(): void
    {
        $this->puzzle = new AppPuzzle([6,4,3,4,1,2,7]);
        $actual = $this->puzzle->isSolved();
        $this->assertFalse($actual);
    }
}