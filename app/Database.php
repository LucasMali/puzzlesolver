<?php

namespace App;

/**
 * Database class
 */
class Database
{
    protected $conn;

    /**
     * Constructor function
     *
     * @param string $servername
     * @param string $username
     * @param string $password
     */
    public function __construct(
        string $servername = '127.0.0.1',
        string $username = 'root',
        string $password = '')
    {

        // Create connection
        $conn = new \mysqli($servername, $username, $password);

        // Check connection
        if ($conn->connect_error) {
            throw new \Exception('Connection failed: ' . $conn->connect_error);
        }

        $this->conn = $conn;
    }

    /**
     * Log Solution function
     *
     * @param int $id
     * @param string $newSeq
     * @param $conn
     * @return void
     */
    public function logSolution(int $id, string $newSeq): void
    {
        $sql = <<< SQL
        UPDATE process SET solved=1, `solved_sequence`=? WHERE id=?
        SQL;
        mysqli_select_db($this->conn, 'puzzle');
        if($stmt = mysqli_prepare($this->conn, $sql)){
            mysqli_stmt_bind_param($stmt, "si", $newSeq, $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $d);
            mysqli_stmt_close($stmt);
        }else{
            echo $this->conn->error . PHP_EOL;
        }
    }

    /**
     * LogSequence function
     *
     * @param array $puzzle
     * @param array $sequence
     * @param $conn
     * @return integer
     */
    public function logSequence(array $puzzle, string $sequence, int $solved = 0): int
    {
        $id = null;
        $sql = <<< SQL
        INSERT INTO process (`puzzle`, `sequence`, `solved`) VALUES (?,?,?)
        SQL;
        mysqli_select_db($this->conn, 'puzzle');
        if($stmt = mysqli_prepare($this->conn, $sql)){
            $puzzle = (int)implode('', $puzzle);
            mysqli_stmt_bind_param($stmt, "isi", $puzzle, $sequence, $solved);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $d);
            mysqli_stmt_fetch($stmt);
            $id = mysqli_insert_id($this->conn);
            mysqli_stmt_close($stmt);
        }else{
            echo $this->conn->error . PHP_EOL;
        }

        return $id;
    }

    public function __destruct()
    {
        mysqli_close($this->conn);
    }
}