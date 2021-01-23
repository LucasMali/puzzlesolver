<?php
namespace App;

/**
 * Puzzle class
 *
 * This is for the gnome puzzle in plants vs zombies.
 * @version 1.0.0
 */
class Puzzle
{
    const SOLUTION = [1,2,3,4,5,6,7];
    public $current;

    /**
     * Constructor function
     *
     * @param array $current
     */
    public function __construct(array $current)
    {
        $this->current = new \SplStack();
        foreach($current as $value)
        {
            $this->current->push($value);
        }
    }

    /**
     * Is Solved function
     *
     * This will return a boolean letting the user know if the puzzle is solved.
     * 
     * @return boolean
     */
    public function isSolved(): bool
    {
        if($this->current->serialize() == (new Puzzle(Puzzle::SOLUTION))->current->serialize()){
            return true;
        }
        return false;
    }

    /**
     * Left function
     * 
     * Shift all items in the puzzle to the left.
     * 
     * @return void
     */
    public function left(): void
    {
        $this->current->push($this->current->shift());
    }

    /**
     * Middle function
     *
     * Swaps the 3rd and 5th items in the puzzle.
     * 
     * @return void
     */
    public function middle(): void
    {
        $t = $this->current->offsetGet(2);
        $this->current->offsetSet(2, $this->current->offsetGet(4));
        $this->current->offsetSet(4, $t);
    }

    /**
     * Right function
     *
     * Shifts all items in the puzzle to the right.
     * 
     * @return void
     */
    public function right(): void
    {
        $this->current->unshift($this->current->pop());
    }
}


