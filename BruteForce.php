<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
require_once('vendor/autoload.php');

use App\Puzzle;

const MAX_RUNS = 1000;
const MAX_MOVES = 50;
const SEQ = ['l','m','r'];

/**
 * Run function
 *
 * Runs the logic to try to solve the puzzle and log to the database.
 * @param Puzzle $app
 * @return void
 */
function run($app, $conn){
    // Generate a sequences.
    $sequence = generateSequence();
    $id = logSequence($sequence, $conn);
    $currentSequence = '';

    // Run through the sequences.
    foreach($sequence as $move){
        $currentSequence .= $move;
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
            logSolution($id, $currentSequence, $conn);
            echo 'S';
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

function logSolution($id, $newSeq, $conn)
{
    $sql = <<< SQL
    UPDATE process SET solved=1, `solved_sequence`=? WHERE id=?
    SQL;
    mysqli_select_db($conn, 'puzzle');
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "si", $newSeq, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $d);
        mysqli_stmt_close($stmt);
    }else{
        echo $conn->error . PHP_EOL;
    }
}

function logSequence($sequence, $conn)
{
    $id = null;
    $sql = <<< SQL
    INSERT INTO process (`sequence`) VALUES (?)
    SQL;
    mysqli_select_db($conn, 'puzzle');
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "s", implode('', $sequence));
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $d);
        mysqli_stmt_fetch($stmt);
        $id = mysqli_insert_id($conn);
        mysqli_stmt_close($stmt);
    }else{
        echo $conn->error . PHP_EOL;
    }

    return $id;
}

function connectDb(){
    $servername = '127.0.0.1';
    $username = 'root';
    $password = '';

    // Create connection
    $conn = new \mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }
    return $conn;    
}

$conn = connectDb();
// Run the app until found.
// while(!$found){
//     $found = run(new Puzzle([1,4,7,2,5,6,3]), $conn;
//     if(!$found){
//         echo 'Not found, trying again' . PHP_EOL;
//     }
// }

// Run the app for a set number of rules.
for($i=0;$i<MAX_RUNS;$i++){
    $found = run(new Puzzle([1,4,7,2,5,6,3]), $conn);
    if(!$found){
        echo '.';
    }
}
mysqli_close($conn);