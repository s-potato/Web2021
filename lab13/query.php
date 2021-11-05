<?php
    $server = 'localhost';
    $user = 'admin';
    $pass = 'adminpass';
    $mydb = 'business_service';
    $businesses_table = 'businesses';
    $mysqli = new mysqli($server, $user, $pass, $mydb, 3306);
    if (!$mysqli) {
        echo "";
    } else {
        if (isset($_GET["name"])) {
            $name = $_GET["name"];
            $select = $mysqli->prepare("Select $businesses_table.name from $businesses_table where $businesses_table.name like ?");
            $name = "$name%";
            $select->bind_param('s', $name);
            if ($select->execute()) {
                $result = $select->get_result();
                $businesses = $result->fetch_all(MYSQLI_ASSOC);
            } else {
                $businesses = array();
            }
            echo json_encode($businesses);
        }
    }
?>