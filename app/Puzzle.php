<?php
namespace App;

class Puzzle
{
    const SOLUTION = [1,2,3,4,5,6,7];
    public $current;

    public function __construct(array $current)
    {
        $this->current = new \SplStack();
        foreach($current as $value)
        {
            $this->current->push($value);
        }
    }

    public function isSolved(): bool
    {
        if($this->current->serialize() == (new Puzzle(Puzzle::SOLUTION))->current->serialize()){
            return true;
        }
        return false;
    }

    public function left()
    {
        // shift all items left
        $this->current->push($this->current->shift());
    }

    public function middle()
    {
        // Swap 3 and 5
        $t = $this->current->offsetGet(2);
        $this->current->offsetSet(2, $this->current->offsetGet(4));
        $this->current->offsetSet(4, $t);
    }

    public function right()
    {
        // shift all items right
        $this->current->unshift($this->current->pop());
    }
}


