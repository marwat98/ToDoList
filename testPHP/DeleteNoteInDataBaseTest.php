<?php

use PHPUnit\Framework\TestCase;
use DataBaseFunction\DeleteFromDataBase;
use DataBaseConnection\DataBase;
use MessageTwigFunction\MessageHandler;

class DeleteNoteInDataBaseTest extends TestCase{

    public function testDeleteNoteFromDataBaseCorrect():void{
        //Mock mysqli statemnent
        $mockMySqliStmt = $this->getMockBuilder(\mysqli_stmt::class)
                                ->disableOriginalConstructor()
                                ->onlyMethods(['bind_param', 'execute'])
                                ->getMock();

        $mockMySqliStmt->method('bind_param')->willReturn(true); 
        $mockMySqliStmt->method('execute')->willReturn(true);    

        // Mock mysqli
        $mockMySqli = $this->getMockBuilder(\mysqli::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['prepare'])
            ->getMock();

        $mockMySqli->method('prepare')->willReturn($mockMySqliStmt);       

        // Mock DataBase
        $mockDatabase = $this->getMockBuilder(DataBase::class)
                                ->setConstructorArgs(['localhost', 'root', '', 'toDoList'])
                                ->onlyMethods(['connection'])
                                ->getMock();

        $mockDatabase->method('connection')->willReturn($mockMySqli);

        // Mock MessageHandler
        $mockMessage = $this->createMock(MessageHandler::class);
        $mockMessage->expects($this->once()) 
        ->method('showMessage')
        ->with(
        $this->equalTo('message.html.twig'),
                $this->equalTo('Pomyślnie usunięto'),
                $this->equalTo(true)
        );

        $mockDeleteNote = new DeleteFromDataBase($mockDatabase, $mockMessage);
        $result = $mockDeleteNote->deleteNote(1,'message.html.twig',"DELETE FROM addToDataBase WHERE id = ?");
        $this->assertTrue($result);



    }
}



?>