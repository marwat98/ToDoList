<?php
    namespace DataBaseFunction;
    use DataBaseConnection\DataBase;
    use ToDoInterface\AddNoteToDataBaseInterface;

    class AddToDataBase implements AddNoteToDataBaseInterface{

        private $twig;
        public function __construct($twig){
            $this->twig = $twig;
        }
        public function addNote(string $note, string $template,string $sqlInsert):bool{

            $db = new DataBase("localhost","root","","toDoList");
            $conn = $db->connection();
            if($conn-> connect_error){
                $this->addMessage($template,"Połączenie z bazą danych nie powiodło się błąd: " . $conn->error,false);
            }

            $stmt = $conn->prepare($sqlInsert);
            if (!$stmt) {
                $this->addMessage($template,"Błąd: " . $stmt->error,false);
            }

            $stmt->bind_param("s", $note);

            $result = $stmt->execute();

            $stmt->close();
            $db->closeConnection();

            if ($result) {
                $this->addMessage($template,"Pomyślnie dodano: " .$note,true);
            } else {
                $this->addMessage($template,"Dodanie notatki " .$note . " nie powiodło się",false);
            }
            
            return $result;
        }
        private function addMessage(string $template,string $message,bool $errorException):void{
            $this->twig->display($template,['message' => $message]);
            if($errorException == false){
                throw new \Exception($message);
            }
        }

    }
?>