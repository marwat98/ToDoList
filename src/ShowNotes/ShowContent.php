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

        $data = array('message'=> "Błąd zapytania SQL: ");

        $db = new DataBase("localhost","root","","toDoList");
        $conn = $db->connection();

        $result = $conn->query($sqlSelect);
        if (!$result) {
            throw new \Exception($this->twig->display($template,$data . $conn->error));
        }

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        $db->closeConnection();
        return $data;
    }
}
?>