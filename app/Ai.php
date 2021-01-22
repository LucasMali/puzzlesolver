<?php
namespace App;

const MAX_MOVES = 100;
const SEQ = ['l','m','r'];

// TODO add a database.

/**
 * Run function
 *
 * Runs the logic to try to solve the puzzle and log to the database.
 * @param Puzzle $app
 * @return void
 */
function run($app){
    // Generate a sequences.
    $sequence = generateSequence();

    // Run through the sequences.
    foreach($sequence as $move){
        switch($move){
            case 'l':
                $app->left();
                break;
            case 'm':
                $app->middle();
                break;
            case 'r':
                $app->right();
                break;
        }
        if($app->isSolved()){
            // log to the process database and quit.
        }
        // log to the sequence database.
    }
    echo 'Done' . PHP_EOL;
    // Log to the process database.
    print_r($app->moves);
}

/**
 * Generate Sequence
 * 
 * This will generate the sequence to try using left, middle, and right.
 *
 * @return array
 */
function generateSequence(): array
{
    $s = [];
    for($i = 0; $i < MAX_MOVES; ++$i)
    {
        $_r = rand(0,2);
        $s[] = SEQ[$_r];
    }

    return $s;
}

// Run the app.
run(new Puzzle([1,2,5,4,3,6,7]));
