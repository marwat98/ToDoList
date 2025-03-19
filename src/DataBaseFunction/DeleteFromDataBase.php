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
            // Data base connection
            $conn = $this->db->connection();
            if ($conn->connect_errno) {
                $this->message->showMessage($template, "Połączenie z bazą danych nie powiodło się");
                return false;
            }
            // Prepare the SQL statement
            $stmt = $conn->prepare($sqlDelete);
            if (!$stmt) {
                $this->message->showMessage($template, "Błąd przygotowania zapytania");
                return false;
            }
            // Bind parameters
            if(!$stmt->bind_param("i", $id)){
                $this->message->showMessage($template, "Błąd bindowania parametrów: " . $stmt->error);
                $stmt->close(); 
                $this->db->closeConnection();
                return false;
            }

            // Execute parameters to data base
            $result = $stmt->execute();

            // Show success or failure message
            $this->message->showMessage(
                $template, 
                $result ? "Pomyślnie usunięto" : "Usunięcie notatki nie powiodło się"
            );
            
            // Close database resources
            $stmt->close(); 
            $this->db->closeConnection();

            return $result;
        }
    }

 
?>