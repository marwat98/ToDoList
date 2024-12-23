<?php
require_once('DataBase.php');
require_once('Interfaces/AddContentToDataBase.php');

class AddToDataBase implements AddContentToDataBase{

    public function addNote(string $note,string $date):bool|mysqli_result{
        $db = new DataBase("localhost","root","","toDoList");
        $conn = $db->connection();

        $sglInsert = "INSERT INTO addToDataBase (note,date_time) VALUES ($note,$date)";
        $stmt = $conn->prepare($sglInsert);

        if (!$stmt) {
            throw new Exception("Error loading statement: " . $conn->error);
        }

        $stmt->bind_param("ss", $note, $date);

        $result = $stmt->execute();

        $stmt->close();
        $db->closeConnection();
        return $result;
    }
}
?>