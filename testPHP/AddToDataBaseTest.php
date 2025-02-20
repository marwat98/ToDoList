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

    public function getMockMySQLStmtTrue(){
        
        $mockMySqliStmt = $this->getMockBuilder(\mysqli_stmt::class)
                                ->disableOriginalConstructor()
                                ->onlyMethods(['bind_param', 'execute'])
                                ->getMock();

        $mockMySqliStmt->method('bind_param')->willReturn(true); 
        $mockMySqliStmt->method('execute')->willReturn(true);    

        return $mockMySqliStmt;
    }
    
    public function getMockMySQLStmtFalse(){
        
        $mockMySqliStmt = $this->getMockBuilder(\mysqli_stmt::class)
                                ->disableOriginalConstructor()
                                ->onlyMethods(['bind_param', 'execute'])
                                ->getMock();

        $mockMySqliStmt->method('bind_param')->willReturn(false); 
        $mockMySqliStmt->method('execute')->willReturn(false);    

        return $mockMySqliStmt;
    }
    
    public function getMockMySQLTrue(){

        $mockMySqli = $this->getMockBuilder(\mysqli::class)
        ->disableOriginalConstructor()
        ->onlyMethods(['prepare'])
        ->getMock();

        $mockMySqli->method('prepare')->willReturn($this->getMockMySQLStmtTrue());   
        
        return $mockMySqli;
    }
    public function getMockMySQLFalse(){

        $mockMySqli = $this->getMockBuilder(\mysqli::class)
        ->disableOriginalConstructor()
        ->onlyMethods(['prepare'])
        ->getMock();

        $mockMySqli->method('prepare')->willReturn($this->getMockMySQLStmtFalse());   
        
        return $mockMySqli;
    }


    public function getMockDataBaseTrue(string $host,string $login, string $password, string $nameDataBase){

        $mockDatabase = $this->getMockBuilder(DataBase::class)
                             ->setConstructorArgs([$host,$login,$password,$nameDataBase])
                             ->onlyMethods(['connection'])
                             ->getMock();

        $mockDatabase->method('connection')->willReturn($this->getMockMySQLTrue());

        return $mockDatabase;
    }
    public function getMockDataBaseFalse(string $host,string $login, string $password, string $nameDataBase){

        $mockDatabase = $this->getMockBuilder(DataBase::class)
                             ->setConstructorArgs([$host,$login,$password,$nameDataBase])
                             ->onlyMethods(['connection'])
                             ->getMock();

        $mockDatabase->method('connection')->willReturn($this->getMockMySQLFalse());

        return $mockDatabase;
    }

    public function getMockMessageHandler(string $twigTemplate,string $message, bool $trueOrFalse){

        $mockMessage = $this->createMock(MessageHandler::class);
        $mockMessage->expects($this->once()) 
                        ->method('showMessage')
                        ->with(
                     $this->equalTo($twigTemplate),
                                $this->equalTo($message),
                                $this->equalTo($trueOrFalse)
                        );
        return $mockMessage;
    }

    public function testFunctionAddNoteOrReturnTrue():void{
        // mock database and message function
        $mockDatabase = $this->getMockDataBaseTrue('localhost', 'root', '', 'toDoList');
        $mockMessage = $this->getMockMessageHandler('message.html.twig','Pomyślnie wykonano operację: marchewka',true);
         // test reaction for add note, category and pieces to database
        $mockAddToDataBase = new AddEditToDataBase($mockDatabase, $mockMessage);
        $result = $mockAddToDataBase->addEditNote(null,'marchewka','warzywa',5,'message.html.twig','INSERT INTO addtodatabase (note,category,pieces) VALUES (?,?,?)');
        $this->assertTrue($result);
    } 

    public function testFunctionAddNoteOrReturnFalse(){
        // mock database and message function
        $mockDatabase = $this->getMockDataBaseFalse('localhost', 'root', '', 'toDoList');
        $mockMessage = $this->getMockMessageHandler('message.html.twig','Operacja nie powiodła się',false);
        // test reaction if program dont connection with database
        $mockAddToDataBase = new AddEditToDataBase($mockDatabase, $mockMessage);
        $result = $mockAddToDataBase->addEditNote(null,'marchewka','warzywa',5,'message.html.twig','INSERT INTO addtodatabase (note,category,pieces) VALUES (?,?,?)');
        $this->assertFalse($result);
    }
}
?>