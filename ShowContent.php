<?php 
require_once('DataBase.php');
require_once('Interfaces/DataBaseContent.php');

class ShowContent implements DataBaseContent{
    public function dataBaseContent():array{
        $db = new DataBase("localhost","root","","toDoList");
        $conn = $db->connection();

        $sql = "SELECT id,note,date_time from addToDataBase";
        $result = $conn->query($sql);
        $data = [];
        
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        $db->closeConnection();
        return $data;
    }
}
?>