<?php 
namespace ShowNotes;
use DataBaseConnection\DataBase;
use interfaces\DataBaseContent;

class ShowContent implements DataBaseContent{
    public function dataBaseContent():array{
        $db = new DataBase("localhost","root","","toDoList");
        $conn = $db->connection();

        $sql = "SELECT id,note,date_time from addToDataBase";
        $result = $conn->query($sql);

        if (!$result) {
            throw new \Exception("Błąd zapytania SQL: " . $conn->error);
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