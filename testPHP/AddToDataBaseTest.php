<?php
namespace TestPHP;

use PHPUnit\Framework\TestCase;
use DataBaseFunction\AddToDataBase;
use DataBaseConnection\DataBase;

/** Imitation mysqli class only to tests */
if (!class_exists('mysqli')) {
    class mysqli {
        public function ping():bool {
            return true; 
        }
    }
}

class AddToDataBaseTest extends TestCase{

    /**@test */
    public function test_add_note_to_database():void{

        // Mocking mysqli class and return function ping on true 
        $mockMysqli = $this->createMock(\mysqli::class);
        // Expects that asking query called out once
        $mockMysqli->expects($this->once())
        ->method('query')
        ->with($this->stringContains("INSERT INTO addToDataBase (note) VALUES ('kupić warzywa')"))
        ->willReturn(true);


        // Mocking database class and return connection function
        $mockDatabase = $this->getMockBuilder(DataBase::class)
        ->setConstructorArgs(['localhost', 'root', '', 'toDoList'])
        ->onlyMethods(['connection'])
        ->getMock();
        $mockDatabase->method('connection')->willReturn($mockMysqli); 

        $mockAddToDataBase = $this->getMockBuilder(AddToDataBase::class)
        ->onlyMethods(['addNote'])
        ->getMock();
        // Expects that the addNote function it will be called out once
        $mockAddToDataBase->expects($this->once())
        ->method('addNote')
        ->with($mockDatabase)
        ->willReturn(true);
        
        // Testing 
        



    }
    
}




?>