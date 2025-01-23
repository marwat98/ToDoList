 <?php
    require_once(__DIR__ . '/../../vendor/autoload.php');
    require_once(__DIR__ . '/../../config.php');
    use DataBaseFunction\AddToDataBase;
    use DataBaseFunction\DeleteFromDataBase;
    use MessageTwigFunction\MessageHandler;
    use DataBaseConnection\DataBase;


    $db = new DataBase("localhost","root","","toDoList");
    $message = new MessageHandler($twig);
    $template = "message.html.twig";

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $press = $_POST['press'] ?? null;
        $note = $_POST['note'] ?? null;

        if(isset($press)){
            switch($press){
                // Action which addition notes to data base
                case "addNote":
                    try{
                        if(empty($note)){
                            throw new Exception("User don't write note");
                        } else {
                            $sqlInsertData = "INSERT INTO addToDataBase (note) VALUES (?)";
                            $addToDataBase = new AddToDataBase($db,$message);
                            $addToDataBase->addNote($note,$template,$sqlInsertData);
                        }
                    } catch (Exception $e) {
                        echo "Error: " . $e->getMessage();
                    }
                break;
                // Action which deleting notes with data base
                case "deleteNote":
                    try{
                        $id = (int)$_POST['id'] ?? null;
                        $sqlDelete = "DELETE FROM addToDataBase WHERE id = ?";
                        $deleteFromDataBase = new DeleteFromDataBase($db,$message);
                        $deleteFromDataBase->deleteNote($id,$template,$sqlDelete);
                    }
                    catch (Exception $e) {
                        echo "Error: " . $e->getMessage();
                    }
                break;
            }
        }
    }
?> 