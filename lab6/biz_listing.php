<html>

<head>
    <title>Business Listings</title>
</head>

<body>
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
            if (isset($_GET["cat_id"])) {
                $cat_id = $_GET["cat_id"];
                $select = $mysqli->prepare("Select $businesses_table.* from $businesses_table, $biz_categories_table where $businesses_table.business_id=$biz_categories_table.business_id and $biz_categories_table.category_id=?");
                $select->bind_param('s', $cat_id);
                
                if ($select->execute()) {
                    $result = $select->get_result();
                    $businesses = $result->fetch_all(MYSQLI_ASSOC);
                } else {
                    $businesses = array();
                }
            }
            $select = "Select * from $categories_table";
            if ($result = $mysqli->query($select)) {
                $categories = $result->fetch_all(MYSQLI_ASSOC);
            } else {
                $categories = array();
            }
            $mysqli->close();
        }
        ?>
        <form id="cat-submit" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
            <tr>
                <td valign="top">
                    <table style="border: 2px solid black; border-collapse: collapse; width:max-content" border=5>
                        <tr>
                            <td><strong>Click on a category to find business listings:</strong></td>
                        </tr>

                        <?php
                        foreach ($categories as $category) {
                            echo "<tr style=\"width: 100%\"><td style=\"border: 2px solid black\">";
                            echo "<a href=\"?cat_id={$category["category_id"]}\">{$category["title"]}</a>";
                            echo "</td></tr>";
                        }
                        ?>

                    </table>
                </td>
                <td valign="top">
                    <table style="border: 1px solid black; border-collapse: collapse">
                        <?php
                        if (isset($_GET["cat_id"])) {
                            foreach ($businesses as $business) {
                                echo "<tr>";
                                foreach ($business as $key => $value) {
                                    echo "<td style=\"border: 1px solid black\">$value</td>";
                                }
                                echo "</td>";
                            }
                        }
                        ?>
                    </table>
                </td>
            </tr>
        </form>
    </table>
</body>

</html>