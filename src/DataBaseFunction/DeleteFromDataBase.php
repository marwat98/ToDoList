<?php
    namespace DataBaseFunction;
    use DataBaseConnection\DataBase;
    use Interfaces\DeleteNoteToDataBaseInterface;
    use MessageTwigFunction\MessageHandler;
    require_once(__DIR__ . '/../../config.php');

    class DeleteFromDataBase implements DeleteNoteToDataBaseInterface{
        private $db;
        private $message;

        public function __construct(DataBase $db, MessageHandler $message){
            $this->db = $db;
            $this->message = $message;
        }
        public function deleteNote(int $id, string $template, string $sqlDelete):bool{

            $conn = $this->db->connection();
            if ($conn->connect_errno) {
                $this->message->showMessage($template, "Połączenie z bazą danych nie powiodło się", false);
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