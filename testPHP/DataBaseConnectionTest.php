<?php
namespace TestPHP;

use PHPUnit\Framework\TestCase;
use DataBaseConnection\DataBase;

class DataBaseConnectionTest extends TestCase{
    /**@test */
    public function testIfArgumentAreString(){
        $host = "localhost";
        $username = "root";
        $password = "";
        $database = "toDoList";
    
        $this->assertIsString($host, "Host is not a string");
        $this->assertIsString($username, "Username is not a string");
        $this->assertIsString($password, "Password is not a string");
        $this->assertIsString($database, "Database name is not a string");

        $db = new DataBase($host, $username, $password, $database);

        $this->assertInstanceOf(DataBase::class, $db);
    }

}
?>