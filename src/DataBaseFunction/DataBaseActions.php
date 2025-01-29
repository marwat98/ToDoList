 <?php
    require_once(__DIR__ . '/../../vendor/autoload.php');
    require_once(__DIR__ . '/../../config.php');
    use DataBaseFunction\AddToDataBase;
    use DataBaseFunction\DeleteFromDataBase;
    use MessageTwigFunction\MessageHandler;
    use DataBaseConnection\DataBase;

    error_reporting(E_ALL);  
    ini_set('display_errors', 1);  


    $db = new DataBase("localhost","root","","toDoList");
    $message = new MessageHandler($twig);
    $template = "message.html.twig";

    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        $press = $_POST['press'];
        $note = $_POST['note'];
        $categories = $_POST['categories'];
        $pieces = (int)$_POST['pieces'];

        if (!isset($_POST['press']) || $_POST['press'] === "" ||
            !isset($_POST['note']) || $_POST['note'] === "" || 
            !isset($_POST['categories']) || $_POST['categories'] === "" ||
            !isset($_POST['pieces']) || !is_numeric($_POST['pieces']) || (int)$_POST['pieces'] <= 0){
                throw new Exception("Błąd: pole nie może być puste");
            } else{
                switch($press){
                    // Action which addition notes to data base
                    case "addNote":
                        try{
                            if(empty($note)){
                                throw new Exception("User don't write note");
                            } else {
                                $sqlInsertData = "INSERT INTO addToDataBase (note,category,pieces) VALUES (?,?,?)";
                                $addToDataBase = new AddToDataBase($db,$message);
                                $addToDataBase->addNote($note,$categories,$pieces,$template,$sqlInsertData);
                            }
                        } catch (Exception $e) {
                            echo "Error: " . $e->getMessage();
                        }
                    break;
                    // Action which deleting notes with data base
                    case "deleteNote":
                        try{
                            $id = (int)$_POST['id'];
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