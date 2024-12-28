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
    
        // Tworzenie instancji obiektu
        $db = new DataBase($host, $username, $password, $database);
    
        // Sprawdzanie typów argumentów (możesz dodać dodatkowe testy)
        $this->assertInstanceOf(DataBase::class, $db);
    }

}
?>