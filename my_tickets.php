<?php include('includes/session.php');?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1, maximum-scale=1, user-scalable=0">
        <title>TikTicket - My tickets</title>
        <link rel="icon" href="images/icons/logo_icon.png">
        <script src="includes/jquery-3.1.1.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Varela+Round&amp;subset=hebrew" rel="stylesheet">
        <link rel="stylesheet" href="includes/stylesheet.css">
        <script src="includes/script.js"></script>
        <script src="includes/table_sorter/jquery.tablesorter.min.js"></script>
        <script src="includes/script_mytickets.js"></script>
        <?php include('includes/db_connection.php');?>
    </head>
    <body>
        <div id="wrapper">
            <header>
                <a id="logo" href="index.php"></a>
                <section>
                    <ul id="userPanel">
                        <li><a href="#">_</a></li>
                        <li><a href="#">סל קניות</a></li>
                        <li><a href="#" class="selected">הכרטיסים שלי</a></li>
                        <li><a href="#">הודעות</a></li>
                        <li id="settingsOption">
                            <a href="#">הגדרות</a>
                            <ul id="userPanelSettings">
                                <li><a href="#">פרופיל</a></li>
                                <li><a href="#">אמצעי תשלום</a></li>
                                <li><a href="#">ביקורות עלי</a></li>
                                <li><a href="includes/logout.php">התנתק</a></li>
                                <li><a href="#">עזרה</a></li>
                            </ul>
                        </li>
                    </ul>
                </section>
                <section>
                    <form id="searchForm" method="get" action="">
                        <label for="category">קטגוריה</label>
                        <select name="category" id="category">
                            <option value="-1" selected disabled hidden>בחר קטגוריה</option>
                        </select>
                        <label for="searchText">חיפוש</label>
                        <input type="search" id="searchText" placeholder="חפש כרטיס לפי שם, או עיר">
                        <input type="submit">
                    </form>
                </section>
            </header>
            <nav>
                <ul id="mainMenu">
                    <li><a href="select_ticket.php?soon=1">כרטיסים ליממה הקרובה</a></li>
                    <li>
                        <a href="select_category.php"> כל הכרטיסים <span>&#9662;</span> </a>
                        <ul id="allTicketsList"></ul>
                    </li>
                    <li><a href="sell_ticket.php">מכירת כרטיס</a></li>
                    <li><a href="#">איך זה עובד</a></li>
                </ul>
            </nav>
            <main>
                <article id="myTickets">
                    <ul id="breadCrumbs">
                        <li><a href="index.php">דף הבית</a>
                            <span class="LeftArrowBreadCrumbs">&#9664;</span>
                        </li>
                        <li><a href="#">הכרטיסים שלי</a></li>
                    </ul>
                    <h1>הכרטיסים שלי</h1>
                    <section id="rightTableSection">
                        <h3 class="orangeText">כרטיסים שפורסמו</h3>
                        <table id="postedTickets">
                            <thead>
                            <tr>
                                <th>  תאריך פרסום &#9662;</th>
                                <th> שם כרטיס &#9662;</th>
                                <th> האם נמכר &#9662;</th>
                                <th> כמות צפיות &#9662;</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $user_id = $_SESSION['user_id'];
                            $querySelect = "SELECT *, DATE_FORMAT(posted_date,'%d/%m/%Y') AS hebDate FROM tbl_221_tickets WHERE posted_by=$user_id";
                            $result = mysqli_query($connection, $querySelect);
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr class=clickable-row data-href=ticket.php?category=" . $row['category'] . "&id=" . $row['id'] . "&mine=1>";
                                echo "<td>" . $row['hebDate']. "</td>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td class='bool'>" . $row['is_sold'] . "</td>";
                                echo "<td>" . $row['views'] . "</td></tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </section>
                    <section id="leftTableSection">
                        <h3 class="blueText">כרטיסים שנרכשו</h3>
                        <table id="boughtTickets">
                            <thead>
                            <tr>
                                <th> תאריך רכישה &#9662;</th>
                                <th> שם כרטיס  &#9662;</th>
                                <th>  נרכש במחיר ₪ &#9662;</th>
                                <th> המוכר &#9662;</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $querySelect = "SELECT *, DATE_FORMAT(bought_date,'%d/%m/%Y') AS hebDate FROM tbl_221_tickets JOIN tbl_221_users ON posted_by=user_id WHERE is_sold=1 and bought_by=$user_id";
                            $result = mysqli_query($connection, $querySelect);
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr class=clickable-row data-href=ticket.php?category=" . $row['category'] . "&id=" . $row['id'] . "&mine=1>";
                                echo "<td>" . $row['hebDate']. "</td>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['price'] . "</td>";
                                echo "<td><a href='#'>" . $row['full_name'] . "</a></td></tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </section>
                    <div class="clear"></div>
                </article>
            </main>
            <footer>
                <ul>
                    <li><a href="#">אודות</a></li>
                    <li><a href="#">צור קשר</a></li>
                    <li><a href="#">שאלות נפוצות</a></li>
                    <li><a href="#">מדיניות ושימוש</a></li>
                </ul>
                <p>Copyright &copy; 2017 Yoav Saroya. All rights reserved</p>
            </footer>
        </div>
    </body>
</html>