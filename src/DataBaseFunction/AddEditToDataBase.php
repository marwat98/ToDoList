<?php
    namespace DataBaseFunction;
    require_once ('C:\xampp\htdocs\ToDoList\config.php');
    use AbstractClasses\AbstractClassAddEditNote;


    class AddEditToDataBase extends AbstractClassAddEditNote{
       
        public function addEditNote(?int $id,string $note, string $categories, int $pieces, string $template, string $sqlInsert): bool{

            $conn = $this->db->connection();
            if ($conn->connect_errno) {
                $this->message->showMessage($template, "Połączenie z bazą danych nie powiodło się", false);
            }
            $stmt = $conn->prepare($sqlInsert);

            if (!$stmt) {
                $this->message->showMessage($template, "Błąd przygotowania zapytania", false);
            }

            if($id !== null){
                $stmt->bind_param("ssii",$note,$categories,$pieces,$id);
            } else {
                $stmt->bind_param("ssi",$note,$categories,$pieces);
            }
            
            $result = $stmt->execute();
            if ($result) {
                $this->message->showMessage($template, "Pomyślnie wykonano operację: " . $note, true);
                
            } else {
                $this->message->showMessage($template, "Operacja nie powiodła się", false);
            }
            
            return $result;

            $stmt->close(); 
            $this->db->closeConnection();
    }
}
?>