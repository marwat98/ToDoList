 <?php
    require_once ('../../config.php');
    use DataBaseFunction\AddEditToDataBase;
    use DataBaseFunction\DeleteFromDataBase;
    use MessageTwigFunction\MessageHandler;
    use DataBaseConnection\DataBase;

    $db = new DataBase("localhost","root","","toDoList");
    $message = new MessageHandler($twig);
    $template = "message.html.twig";

    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        $press = $_POST['press'];
        $note = $_POST['note'];
        $categories = $_POST['categories'];
        $pieces = isset($_POST['pieces']) ? (int)$_POST['pieces'] : null;
        $id2 = isset($_POST['id2']) ? (int)$_POST['id2'] : null;

        switch($press){
            // Action which addition notes 
            case "addNote":
                try{
                    if(empty($note)){
                        throw new Exception("Użytkownik nie wpisał notatki");
                    } else {
                        $sqlInsertData = "INSERT INTO addtodatabase (note,category,pieces) VALUES (?,?,?)";
                        $addToDataBase = new AddEditToDataBase($db,$message);
                        $addToDataBase->addEditNote(null,$note,$categories,$pieces,$template,$sqlInsertData);
                    }

                } catch (Exception $e) {
                        echo "Error: " . $e->getMessage();
                }
            break;
            // Action which edit notes 
            case "editNote":
                try{
                    if(empty($note)){
                        throw new Exception("Użytkownik nie edytował notatki");
                    } else {
                        $sqlInsertData = "UPDATE addtodatabase SET note = ? , category = ? , pieces = ? WHERE id = ?";
                        $editNote = new AddEditToDataBase($db,$message);
                        $editNote->addEditNote($id2,$note,$categories,$pieces,$template,$sqlInsertData);
                    }
                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
                }
            break;
            // Action which deleting notes
            case "deleteNote":
                try{
                    $id = (int)$_POST['id'];
                    $sqlDelete = "DELETE FROM addtodatabase WHERE id = ?";
                    $deleteFromDataBase = new DeleteFromDataBase($db,$message);
                    $deleteFromDataBase->deleteNote($id,$template,$sqlDelete);
                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
                }
            break;
        }
    }  

?> 