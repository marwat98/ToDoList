<?php
    namespace DataBaseFunction;
    require_once ('C:\xampp\htdocs\ToDoList\config.php');
    use AbstractClasses\DataBaseAndMessageTwig;
    use Interfaces\DeleteNoteToDataBaseInterface;

    /**
     * Class which delete notes in data base
     */
    class DeleteFromDataBase extends DataBaseAndMessageTwig implements DeleteNoteToDataBaseInterface{
        /**
         * Delete Note in data base
         * @param int    $id           ID of the note to delete with data base.
         * @param string $template     Twig template for messages.
         * @param string $sqlDelete    SQL statement for delete.
         */
        public function deleteNote(int $id, string $template, string $sqlDelete):bool{

            $conn = $this->db->connection();

            if ($conn->connect_errno) {
                $this->message->showMessage($template, "Połączenie z bazą danych nie powiodło się", false);
                return false;
            }

             $stmt = $conn->prepare($sqlDelete);

            if (!$stmt) {
                $this->message->showMessage($template, "Błąd przygotowania zapytania", false);
            }

            $stmt->bind_param("i", $id);

            $result = $stmt->execute();

            if ($result) {
                $this->message->showMessage($template, "Pomyślnie usunięto", true);
            } else {
                $this->message->showMessage($template, "Usunięcie notatki nie powiodło się", false);
            }

            return $result;

            $stmt->close(); 
            $this->db->closeConnection();
        }
    }

 
?>