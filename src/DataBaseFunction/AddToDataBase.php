<?php
    namespace DataBaseFunction;
    require_once(__DIR__ . '/../../config.php');
    use DataBaseConnection\DataBase;
    use Interfaces\AddNoteToDataBaseInterface;
    use MessageTwigFunction\MessageHandler;

    class AddToDataBase implements AddNoteToDataBaseInterface{
        private $db;
        private $message;

        public function __construct(DataBase $db, MessageHandler $message){
            $this->db = $db;
            $this->message = $message;
        }
        public function addNote(string $note, string $template, string $sqlInsert): bool{

            $conn = $this->db->connection();
            if ($conn->connect_errno) {
                $this->message->showMessage($template, "Połączenie z bazą danych nie powiodło się", false);
            }

            $stmt = $conn->prepare($sqlInsert);
            if (!$stmt) {
                $this->message->showMessage($template, "Błąd przygotowania zapytania", false);
            }

            $stmt->bind_param("s", $note);

            $result = $stmt->execute();
            if ($result) {
                $this->message->showMessage($template, "Pomyślnie dodano: " . $note, true);
                
            } else {
                $this->message->showMessage($template, "Dodanie notatki nie powiodło się", false);
            }
            
            return $result;

            $stmt->close(); 
            $this->db->closeConnection();
    }
}
?>