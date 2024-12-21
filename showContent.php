<?php 

    $conn = mysqli_connect("localhost","root","","toDoList");
    if (mysqli_connect_errno()) {  
        die ("Connection failed: ". mysqli_connect_error());
    }
    $sql = "SELECT id,note,date_time from addToDataBase";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>". $row["id"] ."</td><td>". $row["note"]."</td><td>". $row["date_time"]. "</td></tr>";
        }
    } else {
        echo "0 result";
    }
    $conn->close();
?>