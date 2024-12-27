<?php
    namespace DataBaseFunction;
    use DataBaseConnection\DataBase;
    use ToDoInterface\AddNoteToDataBaseInterface;

    class AddToDataBase implements AddNoteToDataBaseInterface{

        private $twig;
        public function __construct($twig){
            $this->twig = $twig;
        }
        public function addNote(string $note, string $template,$data = array(),string $sqlInsert):bool{

            $db = new DataBase("localhost","root","","toDoList");
            $conn = $db->connection();

            $stmt = $conn->prepare($sqlInsert);

            if (!$stmt) {
                throw new \Exception($this->twig->display($template,$data) . $conn->error);
            }

            $stmt->bind_param("s", $note);

            $result = $stmt->execute();

            $stmt->close();
            $db->closeConnection();

            if ($result) {
                $this->twig->display($template,$data);
            } else {
                $this->twig->display($template,$data) . $conn->error;
            }
            
            return $result;
        }
    }
?>