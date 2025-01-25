<?php

use PHPUnit\Framework\TestCase;
use DataBaseFunction\DeleteFromDataBase;
use DataBaseConnection\DataBase;
use MessageTwigFunction\MessageHandler;

class DeleteNoteInDataBaseTest extends TestCase{

    public function testDeleteNoteFromDataBaseCorrect():void{
        //Mock mysqli statement
        $mysqli_stmt = $this->getMockBuilder(\mysqli_stmt::class)
                            ->disableOriginalConstructor()
                            ->onlyMethods(['bind_param','execute'])
                            ->getMock();
        $mysqli_stmt -> method('bind_param')->willReturn(true);
        $mysqli_stmt -> method('execute')->willReturn(true);
        //Mock mysqli class
        $mysqli = $this->getMockBuilder(\mysqli::class)
                        ->disableOriginalConstructor()
                        ->onlyMethods(['prepare'])
                        ->getMock();
        $mysqli -> method('prepare')->willReturn($mysqli_stmt);
        //Mock data base
        $mockDataBase = $this->getMockBuilder(DataBase::class)
                                ->setConstructorArgs(['localhost', 'root', '', 'toDoList'])
                                ->onlyMethods(['connection'])
                                ->getMock();
        $mockDataBase -> method('connection')->willReturn($mysqli);
        //Mock MessageHandler
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