<?php 
namespace DataBaseConnection;

class DataBase{
    private string $host;
    private string $username;
    private string $password;
    private string $database;
    private ?\mysqli $conn = null;


    public function __construct(string $host, string $username, string $password, string $database){
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }
    public function connection(): ?\mysqli {
        if ($this->conn === null) {
            $this->conn = new \mysqli($this->host, $this->username, $this->password, $this->database);
            
            if ($this->conn->connect_errno) {
                die("Connection failed: " . $this->conn->connect_error);
            }
        }
        return $this->conn;
    }
    public function closeConnection(): void {
        if ($this->conn !== null) {
            $this->conn->close();
            $this->conn = null;
        }
    }
}








?>