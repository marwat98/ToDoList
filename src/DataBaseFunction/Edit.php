<?php
    namespace DataBaseFunction;
    require_once ('../../config.php');
    use DataBaseConnection\DataBase;
    use MessageTwigFunction\MessageHandler;

    class Edit{
        private $db;
        private $message;
    
        public function __construct(DataBase $db, MessageHandler $message){
            $this->db = $db;
            $this->message = $message;
        }
        public function editNote(int $id,string $note, string $categories, int $pieces, string $template, string $sqlInsert): bool{

            $conn = $this->db->connection();
            if ($conn->connect_errno) {
                $this->message->showMessage($template, "Połączenie z bazą danych nie powiodło się", false);
            }
            $stmt = $conn->prepare($sqlInsert);
            if (!$stmt) {
                $this->message->showMessage($template, "Błąd przygotowania zapytania", false);
            }
            $stmt->bind_param("ssii",$note,$categories,$pieces,$id);
            
            $result = $stmt->execute();
            if ($result) {
                $this->message->showMessage($template, "Pomyślnie edytowano notatkę", true);
                
            } else {
                $this->message->showMessage($template, "Edytowanie notatki nie powiodło się", false);
            }
            
            return $result;

            $stmt->close(); 
            $this->db->closeConnection();
    }
}



?>