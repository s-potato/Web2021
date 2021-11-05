<html>

<head>
    <title>Business Registration</title>
</head>

<body>
    <h1>Business Registration</h1>
    <table>
        <?php
        $server = 'localhost';
        $user = 'admin';
        $pass = 'adminpass';
        $mydb = 'business_service';
        $businesses_table = 'businesses';
        $categories_table = 'categories';
        $biz_categories_table = 'biz_categories';
        $mysqli = new mysqli($server, $user, $pass, $mydb, 3306);
        if (!$mysqli) {
            die("Cannot connect to $server using $user");
        } else {
            if ($result = $mysqli->query("select * from $categories_table")) {
                $categories = $result->fetch_all(MYSQLI_ASSOC);
            } else {
                $categories = array();
            }
            $categories_id = array();
            if (isset($_POST["submit"])) {
                echo "<p>Record inserted as shown below</p>";
                $name = $_POST["name"];
                $address = $_POST["address"];
                $city = $_POST["city"];
                $telephone = $_POST["telephone"];
                $url = $_POST["url"];
                $categories_id = $_POST["categories_id"];
                $insert = $mysqli->prepare("insert into $businesses_table(name, address, city, telephone, url) values (?, ?, ?, ?, ?)");
                $insert->bind_param("sssss", $name, $address, $city, $telephone, $url);
                if (!$insert->execute()) {
                    echo $mysqli->error;
                };
                $select =  $mysqli->prepare("select * from $businesses_table where name=? and address=? and city=? and telephone=? and url=? order by business_id desc");
                $select->bind_param("sssss", $name, $address, $city, $telephone, $url);
                if ($select->execute()){
                    $result = $select->get_result();
                    $business = $result->fetch_row();
                    $business_id = intval($business[0]);
                }
                foreach ($categories_id as $category_id) {
                    $insert = $mysqli->prepare("insert into $biz_categories_table values (?,?)");
                    $insert->bind_param("ds",$business_id, $category_id);
                    if ($insert->execute()) {
                        echo $mysqli->error;
                    };
                }
            }
            $mysqli->close();
        }
        ?>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <tr>
                <td rowspan="5">
                    <?php
                    if (isset($_POST["submit"])) {
                        echo "<p>Selected category values are highlighted</p>";
                    } else {
                        echo "<p>Click on one, or control-click on multiple categories</p>";
                    }
                    ?>
                    <select name="categories_id[]" required multiple>
                        <?php
                        foreach ($categories as $category) {
                            if (isset($_POST["submit"]) && in_array($category["category_id"], $categories_id)) {
                                echo "<option selected value=\"{$category["category_id"]}\">{$category["title"]}</option>";
                            } else {
                                echo "<option value=\"{$category["category_id"]}\">{$category["title"]}</option>";
                            }
                        }
                        ?>
                    </select>
                </td>
                <td><label>Business name: </label></td>
                <td>
                    <input type="text" size="50" name="name" value="<?php echo (isset($_POST["submit"])) ? $name : ''; ?>" required />
                </td>
            </tr>
            <tr>
                <td><label>Address: </label></td>
                <td>
                    <input type="text" size="50" name="address" value="<?php echo (isset($_POST["submit"])) ? $address : ''; ?>" required />
                </td>
            </tr>
            <tr>
                <td><label>City: </label></td>
                <td>
                    <input type="text" size="50" name="city" value="<?php echo (isset($_POST["submit"])) ? $city : ''; ?>" required />
                </td>
            </tr>
            <tr>
                <td><label>Telephone: </label></td>
                <td>
                    <input type="tel" pattern="^([0]{1}[0-9]{9}|[0]{1}[0-9]{10})$" size="50" name="telephone" value="<?php echo (isset($_POST["submit"])) ? $telephone : ''; ?>" required />
                </td>
            </tr>
            <tr>
                <td><label>URL: </label></td>
                <td>
                    <input type="url" size="50" name="url" value="<?php echo (isset($_POST["submit"])) ? $url : ''; ?>" required />
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    if (isset($_POST["submit"])) {
                        echo "<a href=\"\" onclick=\"location.reload();\">Add Another Business</a>";
                    } else {
                        echo "<input type=\"submit\" name=\"submit\" value=\"Add business\">";
                    }
                    ?>

                </td>
            </tr>
        </form>
    </table>
</body>

</html>