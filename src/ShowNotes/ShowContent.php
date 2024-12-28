<?php 
namespace ShowNotes;
require_once(__DIR__ . '/../../vendor/autoload.php');
use DataBaseConnection\DataBase;
use ToDoInterface\DataBaseInterface;

class ShowContent implements DataBaseInterface{
    private $twig;

    public function __construct($twig){
        $this->twig = $twig;
    }
    public function dataBaseContent(string $sqlSelect, string $template):array{

        $db = new DataBase("localhost","root","","toDoList");
        $conn = $db->connection();
        if ($conn->connect_error) {
            $this->showMessageException($template, "Błąd połączenia: " . $conn->connect_error,false);
        }

        $result = $conn->query($sqlSelect);
        if (!$result) {
           $this->showMessageException($template,"Błąd zapytania SQL: " . $conn->error,false);
        }

        $content = [];
        while ($row = $result->fetch_assoc()) {
            $content[] = $row;
        }
        
        $db->closeConnection();
        return $content;
    }
    private function showMessageException(string $template,string $message,bool $errorException):void{
        $this->twig->display($template,['message'=> $message]);
        if($errorException == false){
            throw new \Exception($message);
        }
    }
}
?>