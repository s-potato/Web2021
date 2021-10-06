<html>

<head>

</head>

<body>
    <p>Convert radian and degree</p>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <?php
        if (isset($_POST["radian"])) {
            $radian = $_POST["radian"];
            $degree = $radian * 180 / pi();
        }
        ?>
        <table>
            <tr>
                <td>
                    <label>Radians</label>
                    <input type="number" name="radian" required>
                </td>
            </tr>
            <tr>
                <td><input type="submit" name="summit1" value="Submit"></td>
            </tr>

        </table>
        <?php
        if (isset($_POST["radian"])) {
            print("$radian rad = $degree deg");
        }
        ?>
    </form>


    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <?php
        if (isset($_POST["degree"])) {
            $degree = $_POST["degree"];
            $radian = $degree * pi() / 180;
        }
        ?>
        <table>
            <tr>
                <td>
                    <label>Degrees</label>
                    <input type="number" name="degree" required>
                </td>
            </tr>
            <tr>
                <td><input type="submit" name="summit2" value="Submit"></td>
            </tr>
        </table>
        <?php
        if (isset($_POST["degree"])) {
            print("$degree deg = $radian rad");
        }
        ?>
    </form>
</body>

</html>