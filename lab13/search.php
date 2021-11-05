<html>

<head>
    <title>Business Listings</title>
</head>

<body>
    <?php
    $server = 'localhost';
    $user = 'admin';
    $pass = 'adminpass';
    $mydb = 'business_service';
    $businesses_table = 'businesses';
    $mysqli = new mysqli($server, $user, $pass, $mydb, 3306);
    if (!$mysqli) {
        die("Cannot connect to $server using $user");
    } else {
        if (isset($_GET["submit"])) {
            $name = $_GET["name"];
            $select = $mysqli->prepare("Select * from $businesses_table where $businesses_table.name=?");
            $select->bind_param('s', $name);
            if ($select->execute()) {
                $result = $select->get_result();
                $businesses = $result->fetch_all(MYSQLI_ASSOC);
            } else {
                $businesses = array();
            }
        }
    }
    ?>
    <p>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
        <label>Search: </label>
        <input type="text" size=50 name="name" onkeyup="suggestion(this.value);" required>
        <input type="submit" value="Submit" name="submit">
    </form>
    </p>
    <p id="suggest">
    </p>
    <table style="border: 1px solid black; border-collapse: collapse; width:100%">
        <?php
        if (isset($_GET["submit"])) {
            echo "<tr><th>Business ID</th><th>Name</th><th>Address</th><th>City</th><th>Telephone</th><th>URL</th></tr>";
            foreach ($businesses as $business) {
                echo "<tr>";
                foreach ($business as $key => $value) {
                    echo "<td style='text-align: center;'>$value</td>";
                }
                echo "</td>";
            }
        }
        ?>
    </table>
</body>
<script>
    function getHTTPObject() {
        if (window.ActiveXObject) {
            return new ActiveXObject("Microsoft.XMLHTTP");
        } else if (window.XMLHttpRequest) {
            return new XMLHttpRequest();
        } else {
            alert("Your browser does not support AJAX.");
            return null;
        }
    }

    function suggestion(input) {
        var parent = document.getElementById("suggest");
        while (parent.firstChild) {
            parent.firstChild.remove();
        }
        var request = getHTTPObject();
        if (input && request!=null) {
            parent.innerHTML = "Suggestion:";
            request.open("GET", "./query.php?name=" + input);
            request.onreadystatechange = () => {
                if (request.readyState === 4 && request.responseText) {
                    obj = JSON.parse(request.responseText);
                    obj.forEach((i) => {
                        child = document.createElement("li");
                        child.innerHTML = i.name;
                        parent.appendChild(child);
                    });
                }
            }
            request.send(null);
        }
    }
</script>

</html>