<?php
namespace TestPHP;
use PHPUnit\Framework\TestCase;
use DataBaseFunction\AddEditToDataBase;
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
        $mockMessage->expects($this->once()) 
                        ->method('showMessage')
                        ->with(
                     $this->equalTo('message.html.twig'),
                                $this->equalTo('Pomyślnie dodano: marchewka'),
                                $this->equalTo(true)
                        );

        // Test AddToDataBase
        $mockAddToDataBase = new AddEditToDataBase($mockDatabase, $mockMessage);
        $result = $mockAddToDataBase->addEditNote(null,'marchewka','pieczywo',5,'message.html.twig','INSERT INTO addtodatabase (note,category,pieces) VALUES (?,?,?)');
        $this->assertTrue($result);
    } 
    
}
?>