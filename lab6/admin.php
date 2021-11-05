<html>

<head>
    <title>Category Administration</title>
</head>

<body>
    <style>
        table {
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th {
            background-color: grey;
        }
    </style>
    <h1>Category Administration</h1>
    <table>
        <tr>
            <th>Cat ID</th>
            <th>Title</th>
            <th>Description</th>
        </tr>
        <?php
        $server = 'localhost';
        $user = 'admin';
        $pass = 'adminpass';
        $mydb = 'business_service';
        $table_name = 'categories';
        $mysqli = new mysqli($server, $user, $pass, $mydb, 3306);
        if (!$mysqli) {
            die("Cannot connect to $server using $user");
        } else {
            if (isset($_POST["submit"])) {
                $category_id = $_POST["category_id"];
                $title = $_POST["title"];
                $description = $_POST["description"];
                $insert = $mysqli->prepare("insert into $table_name values (?,?,?)");
                $insert->bind_param("sss",$category_id, $title, $description);
                if ($insert->execute()) {
                    echo $mysqli->error;
                };
            }
            $select = "Select * from $table_name";
            if ($result = $mysqli->query($select)) {
                $categories = $result->fetch_all(MYSQLI_ASSOC);
                foreach ($categories as $category) {
                    echo "<tr>";
                    foreach ($category as $key => $value) {
                        echo "<td>$value</td>";
                    }
                    echo "</td>";
                }
            } else {
                $categories = array();
            }
            $mysqli->close();
        }
        ?>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <tr>
                <td><input type="text" size="10" name="category_id" required /></td>
                <td><input type="text" size="50" name="title" required /></td>
                <td><input type="text" size="100" name="description" required /></td>
            </tr>
            <tr>
                <td><input type="submit" name="submit" value="Add category"></td>
            </tr>
        </form>
    </table>
</body>

</html>