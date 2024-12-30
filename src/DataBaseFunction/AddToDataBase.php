<?php
    namespace DataBaseFunction;
    require_once(__DIR__ . '/../../config.php');
    use DataBaseConnection\DataBase;
    use ToDoInterface\AddNoteToDataBaseInterface;
    use MessageTwigFunction\MessageHandler;

    class AddToDataBase implements AddNoteToDataBaseInterface{
        public function addNote(string $note, string $template,string $sqlInsert):bool{

            $message = new MessageHandler($twig);

            $db = new DataBase("localhost","root","","toDoList");
            $conn = $db->connection();
            if($conn-> connect_error){
                $message->showMessage($template,"Połączenie z bazą danych nie powiodło się błąd: " . $conn->error,false);
            }

            $stmt = $conn->prepare($sqlInsert);
            if (!$stmt) {
                $message->showMessage($template,"Błąd: " . $stmt->error,false);
            }

            $stmt->bind_param("s", $note);

            $result = $stmt->execute();

            $stmt->close();
            $db->closeConnection();

            if ($result) {
                $message->showMessage($template,"Pomyślnie dodano: " .$note,true);
            } else {
                $message->showMessage($template,"Dodanie notatki " .$note . " nie powiodło się",false);
            }
            
            return $result;
        }
    }
?>