<html>

<body>
    <h3>Enter your name and select date and time for the appointment</h3>
    <br>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
        <?php
        if (array_key_exists("username", $_GET)) {
            $username = $_GET["username"];
            $date = $_GET["date"];
            $fdate = (new DateTime($date))->format("j/n/Y");
            $time = $_GET["time"];
            $adate = explode("/", $fdate);
            $atime = explode(":", $time);
        } else {
            $date = 0;
            $time = 0;
        }
        ?>
        <table>
            <tr>
                <td>Your name:</td>
                <td><input type="text" size="16" name="username" value="<?php echo (isset($username)) ? $username : ''; ?>" required /></td>
            </tr>
            <tr>
                <td>Date:</td>
                <td><input type="date" name="date" value="<?php echo (isset($date)) ? $date : ''; ?>" required /></td>
            </tr>
            <tr>
                <td>Time:</td>
                <td><input type="time" name="time" value="<?php echo (isset($time)) ? $time : ''; ?>" step="1" required /></td>
            </tr>
        </table>
        <input type="submit" value="Submit">
        <table>

            <?php

            if (array_key_exists("username", $_GET)) {
                print("Hi $username!<br></br>");
                print("You have choose to have an appointment on $time, $fdate<br></br>");
                print("More information<br></br>");
                if ($atime[0] >= 12) {
                    $atime[0] -= 12;
                    $temp = "PM";
                } else {
                    $temp = "AM";
                }
                print("In 12 hours, the time and date is $atime[0]:$atime[1]:$atime[2] $temp, $fdate<br></br>");
                $nhuan = 0;
                if (($adate[2] % 4 == 0 && $adate[2] % 100 != 0) || ($adate[2] % 100 == 0 && $adate[2] % 400 == 0)) {
                    $nhuan = 1;
                }
                switch ($adate[1]) {
                    case 1:
                    case 3:
                    case 5:
                    case 7:
                    case 8:
                    case 10:
                    case 12:
                        print("<br>This month has 31 days");
                        break;
                    case 4:
                    case 6:
                    case 9:
                    case 11:
                        print("<br>This month has 30 days");
                        break;
                    case 2:
                        if ($nhuan == 0) {
                            print("<br>This month has 28 days");
                        } else {
                            print("<br>This month has 29 days");
                        }
                        break;
                    default:
                        break;
                }
            }
            ?>
        </table>
    </form>
</body>

</body>

</html>