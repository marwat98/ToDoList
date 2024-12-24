<?php
require_once('src/ShowNotes/ShowContent.php');
require_once('interfaces/AddContentToDataBase.php');

class AddToDataBase implements AddContentToDataBase{

    public function addNote(string $note,string $date):bool{
        $db = new DataBase("localhost","root","","toDoList");
        $conn = $db->connection();

        $sglInsert = "INSERT INTO addToDataBase (note,date_time) VALUES (?,?)";
        $stmt = $conn->prepare($sglInsert);

        if (!$stmt) {
            throw new Exception("Error loading statement: " . $conn->error);
        }

        $stmt->bind_param("ss", $note, $date);

        $result = $stmt->execute();

        $stmt->close();
        $db->closeConnection();

        if ($result) {
            echo "Pomyślnie dodano rekord: " . $note;
        } else {
            echo "Wystąpił błąd podczas dodawania: " . $conn->error;
        }
        
        return $result;
    }
}
?>