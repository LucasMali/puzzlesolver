<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
require_once('vendor/autoload.php');

use App\Database;
use App\Puzzle;
use App\PuzzleSolver;

// Run the app for a set number of rules.
try{
    $db = new Database();
    for($i=0;$i<PuzzleSolver::MAX_RUNS;$i++){
        $puzzle = new Puzzle([6,4,2,5,1,7,3]);
        $found = (new PuzzleSolver($db))->run($puzzle);
        if($found){
            echo 'S';
        }
    }
}catch (\Throwable $e){
    echo 'Oh nos ' . $e->getMessage();
}
