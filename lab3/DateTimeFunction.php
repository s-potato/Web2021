<html>

<body>
    <h3>Enter your name and select date and time for the appointment</h3>
    <br>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <?php
        if (isset($_POST["name1"])) {
            $name1 = $_POST["name1"];
            $name2 = $_POST["name2"];
            $date1 = $_POST["date1"];
            $date2 = $_POST["date2"];
        }
        ?>
        <table>
            <tr>
                <td>First person's name:</td>
                <td><input type="text" size="16" name="name1" value="<?php echo (isset($name1)) ? $name1 : ''; ?>" required /></td>
            </tr>
            <tr>
                <td>First person's birthday:</td>
                <td><input type="date" name="date1" value="<?php echo (isset($date1)) ? $date1 : ''; ?>" max="<?= date('Y-m-d'); ?>" required /></td>
            </tr>
            <tr>
                <td>First person's name:</td>
                <td><input type="text" size="16" name="name2" value="<?php echo (isset($name2)) ? $name2 : ''; ?>" required /></td>
            </tr>
            <tr>
                <td>First person's birthday:</td>
                <td><input type="date" name="date2" value="<?php echo (isset($date2)) ? $date2 : ''; ?>" max="<?= date('Y-m-d'); ?>" required /></td>
            </tr>
        </table>
        <input type="submit" value="Submit">
        <table>
            <?php
            if (isset($_POST["name1"])) {
                $odate1 = new DateTime($date1);
                $odate2 = new DateTime($date2);
                $diff = date_diff($odate1, $odate2)->format("%a");
                $fdate1 = $odate1->format("N, F m, Y");
                $fdate2 = $odate2->format("N, F m, Y");
                $today = new DateTime("now");
                $age1 = date_diff($odate1, $today)->format("%y");
                $age2 = date_diff($odate2, $today)->format("%y");
                print("<br>$name1's birthday: $fdate1<br>");
                print("$name2's birthday: $fdate2<br>");
                print("Date different: $diff<br>");
                print("$name1's age: $age1<br>");
                print("$name2's age: $age2<br>");
            }
            ?>
        </table>
    </form>
</body>

</body>

</html>