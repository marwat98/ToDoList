<?php
namespace TestPHP;

use PHPUnit\Framework\TestCase;
use DataBaseFunction\AddToDataBase;
use DataBaseConnection\DataBase;
use MessageTwigFunction\MessageHandler;

/** Imitation mysqli class only to tests */
if (!class_exists('mysqli')) {
    class mysqli {
        public function ping():bool {
            return true; 
        }
    }
}

class AddToDataBaseTest extends TestCase{

    public function testConnectErrorOrReturnFalse(): void {
        // Mocking mysqli class and return function ping on false 
        $mockMysqli = $this->createMock(\mysqli::class);
        $mockMysqli->method('ping')->willReturn(false);

        // Mocking database class and return connection function
        $mockDatabase = $this->getMockBuilder(DataBase::class)
                             ->setConstructorArgs(['localhost', 'root', '', 'toDoList'])
                             ->onlyMethods(['connection'])
                             ->getMock();
        $mockDatabase->method('connection')->willReturn($mockMysqli); 

        //Testing
        $conn = $mockDatabase->connection();
        if($conn-> connect_error){
            $mockMessage = $this->createMock(MessageHandler::class);
            $mockMessage->expects($this->once())
            ->method('showMessage')
            ->with(
                $$this->equalTo('message.html.twig'),         
                $this->equalTo('Błąd: Mocked error'),         
                $this->equalTo(false)
            );
        }
        $this->assertInstanceOf(\mysqli::class, $conn);
    }
 
    public function testFunctionAddNoteOrReturnTrue():void{

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
        $mockMessage->expects($this->once()) // Powinno być wywołane tylko raz
                        ->method('showMessage')
                        ->with(
                     $this->equalTo('message.html.twig'),
                                $this->equalTo('Pomyślnie dodano: marchewka'),
                                $this->equalTo(true)
                        );

        // Test AddToDataBase
        $mockAddToDataBase = new AddToDataBase($mockDatabase, $mockMessage);
        $result = $mockAddToDataBase->addNote('marchewka','message.html.twig','INSERT INTO addToDataBase (note) VALUES (?)');
        $this->assertTrue($result);
    } 
    
}
?>