 <?php
    require_once ('../../config.php');
    use DataBaseFunction\AddEditToDataBase;
    use DataBaseFunction\DeleteFromDataBase;
    use MessageTwigFunction\MessageHandler;
    use DataBaseConnection\DataBase;

    // error_reporting(E_ALL);  
    // ini_set('display_errors', 1);  


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
                            if(empty($note) && empty($categories) && empty($pieces)){
                                throw new Exception("Użytkownik nie wpisał notatki , nie wybrał kategori , nie wpisał ilości");
                            } else {
                                $sqlInsertData = "INSERT INTO addtodatabase (note,category,pieces) VALUES (?,?,?)";
                                $addToDataBase = new AddEditToDataBase($db,$message);
                                $addToDataBase->addEditNote(null,$note,$categories,$pieces,$template,$sqlInsertData);
                            }
                        } catch (Exception $e) {
                            echo "Error: " . $e->getMessage();
                        }
                    break;
                    case "editNote":
                        try{
                            if(empty($note) && empty($categories) && empty($pieces)){
                                throw new Exception("Użytkownik nie wpisał notatki , nie wybrał kategori , nie wpisał ilości");
                            } else {
                                $sqlInsertData = "UPDATE addtodatabase SET note = ? , category = ? , pieces = ? WHERE id = ?";
                                $editNote = new AddEditToDataBase($db,$message);
                                $editNote->addEditNote($id,$note,$categories,$pieces,$template,$sqlInsertData);
                            }
                        } catch (Exception $e) {
                            echo "Error: " . $e->getMessage();
                        }
                    break;
                    // Action which deleting notes with data base
                    case "deleteNote":
                        try{
                            $id = (int)$_POST['id'];
                            $sqlDelete = "DELETE FROM addtodatabase WHERE id = ?";
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