<?php
namespace App;

// This should be part of the AI.
function run($app){
    while(Puzzle::SOLUTION != $app->current){
        if(count($app->moves) >= 2){
            throw new \Exception("Too many moves!");
        }

        $app->moves[] = 'l';
    }
    echo 'Done' . PHP_EOL;
    print_r($app->moves);
}

// This will be moved to the AI
try{
    $app = new Puzzle([1,2,5,4,3,6,7]);
}catch(\Throwable $e){
    echo $e->getMessage() . PHP_EOL;
    print_r($app->moves);
}