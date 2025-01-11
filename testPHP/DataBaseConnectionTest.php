<?php
namespace TestPHP;

use PHPUnit\Framework\TestCase;
use DataBaseConnection\DataBase;

/** Imitation mysqli class only to tests */
if (!class_exists('mysqli')) {
    class mysqli {
        public function ping():bool {
            return true; 
        }
    }
}

class DataBaseConnectionTest extends TestCase{
    /**@test */
    public function test_if_arguments_in_data_base_are_string():void{
        $host = "localhost";
        $username = "root";
        $password = "";
        $database = "toDoList";
        // Checking
        $this->assertIsString($host, "Host is not a string");
        $this->assertIsString($username, "Username is not a string");
        $this->assertIsString($password, "Password is not a string");
        $this->assertIsString($database, "Database name is not a string");

        $db = new DataBase($host, $username, $password, $database);

        $this->assertInstanceOf(DataBase::class, $db);
    }
    /** @test */
    public function test_connection():void{

        // Mocking mysqli class and return function ping on true 
        $mockMysqli = $this->createMock(\mysqli::class);
        $mockMysqli->method('ping')->willReturn(true);

        // Mocking database class and return connection function
        $mockDatabase = $this->getMockBuilder(DataBase::class)
                             ->setConstructorArgs(['localhost', 'root', '', 'toDoList'])
                             ->onlyMethods(['connection'])
                             ->getMock();
        $mockDatabase->method('connection')->willReturn($mockMysqli); 

        // Testing 
        $conn = $mockDatabase->connection();
        $this->assertInstanceOf(\mysqli::class, $conn);
    }
}
?>