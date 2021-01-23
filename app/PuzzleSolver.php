<?php
namespace App;

/**
 * PuzzleSolver class
 * @version 1.0.0
 */
class PuzzleSolver
{
    const MAX_RUNS = 5000;
    const MAX_MOVES = 50; // Do not increase unless you change the database variables.
    const SEQ = ['l','m','r'];

    public Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }
    /**
     * Run function
     *
     * Runs the logic to try to solve the puzzle and log to the database.
     * @param Puzzle $puzzle
     * @return void
     */
    public function run(Puzzle $puzzle){
        // Generate a sequences.
        $sequence = $this->generateSequence();
        $currentSequence = '';

        // Run through the sequences.x
        foreach($sequence as $move){
            $currentSequence .= $move;
            switch($move){
                case 'l':
                    $puzzle->left();
                    break;
                case 'm':
                    $puzzle->middle();
                    break;
                case 'r':
                    $puzzle->right();
                    break;
            }
            if($puzzle->isSolved()){
                $this->db->logSequence($puzzle->problem, $currentSequence, 1);
                return true;
            }
        }
    }

    /**
     * Generate Sequence
     * 
     * This will generate the sequence to try using left, middle, and right.
     *
     * @return array
     */
    public function generateSequence(): array
    {
        $s = [];
        for($i = 0; $i < self::MAX_MOVES; ++$i)
        {
            $_r = rand(0,2);
            $_s = self::SEQ[$_r];
            if(
                ($_s === 'm' && $s[$i-1] === 'm')
                || ($_s === 'l' && $s[$i-1] === 'r')
                || ($_s === 'r' && $s[$i-1] === 'l')
            ){
                continue;
            }
            $s[] = $_s;
        }

        return $s;
    }
}


