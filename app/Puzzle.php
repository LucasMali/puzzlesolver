<?php
namespace App;

class Puzzle
{
    const SOLUTION = [1,2,3,4,5,6,7];
    public $current;
    public $moves = [];

    public function __construct(array $current)
    {
        $this->current = new \SplStack();
        foreach($current as $value)
        {
            $this->current->push($value);
            print_r($this->current);
        }
    }

    public function left()
    {
        // shift all items left
    }

    public function middle()
    {
        // Swap 3 and 5
    }

    public function right()
    {
        // shift all items right
    }
}


