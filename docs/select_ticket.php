<?php include('includes/session.php');?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1, maximum-scale=1, user-scalable=0">
        <title>TikTicket - Select Ticket</title>
        <link rel="icon" href="images/icons/logo_icon.png">
        <script src="includes/jquery-3.1.1.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Varela+Round&amp;subset=hebrew" rel="stylesheet">
        <link rel="stylesheet" href="includes/stylesheet.css">
        <script src="includes/table_sorter/jquery.tablesorter.min.js"></script>
        <script src="includes/script.js"></script>
        <script src="includes/script_select_ticket.js"></script>
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
                        <li><a href="my_tickets.php">הכרטיסים שלי</a></li>
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
                    <?php
                    if(isset($_GET['soon'])) echo "<li class='mainSelected'><a href=\"#\">כרטיסים ליממה הקרובה</a></li><li>";
                    else echo "<li><a href=\"select_ticket.php?soon=1\">כרטיסים ליממה הקרובה</a></li><li class=\"mainSelected\">";
                    ?>
                    <a href="select_category.php"> כל הכרטיסים <span>&#9662;</span> </a>
                    <ul id="allTicketsList"></ul>
                    </li>
                    <li><a href="sell_ticket.php">מכירת כרטיס</a></li>
                    <li><a href="#">איך זה עובד</a></li>
                </ul>
            </nav>
            <main>
                <article id="selectTicket">
                    <ul id="breadCrumbs">
                        <li><a href="index.php">דף הבית</a>
                            <span class="LeftArrowBreadCrumbs">&#9664;</span>
                        </li>

                        <?php
                        if(!isset($_GET['soon'])) echo "<li><a href=\"select_category.php\">בחירת קטגוריה</a>
                            <span class=\"LeftArrowBreadCrumbs\">&#9664;</span>
                        </li>";
                        ?>
                        <li><a href="#" id="lastItemBreadCrumbs"></a></li>
                    </ul>
                    <h1></h1>
                    <?php
                    if(isset($_GET['search']))
                        echo "<h4> מציג תוצאות חיפוש לפי: <span class='redText'>". $_GET['search'] .  "</span></h4>";
                    ?>
                    <table id="tableCategories">
                        <?php
                        echo "<thead><tr>";
                        echo "<th>מס' כרטיס&#9662;</th>";
                        if(isset($_GET['soon'])) {
                            echo "<th>שם&#9662;</th>
                                <th>עיר&#9662;</th>
                                <th>מחיר &#8362;&#9662; </th>
                                <th>קטגוריה&#9662;</th>
                                <th>פירוט</th></tr></thead><tbody>";//parsing the data inside the table
                            $querySelect = "SELECT * FROM  tbl_221_tickets NATURAL LEFT OUTER JOIN  tbl_221_shows NATURAL LEFT OUTER JOIN  tbl_221_parks NATURAL LEFT OUTER JOIN (SELECT id, DATE AS hotel_date, nights FROM  tbl_221_hotels) AS T";
                            $result = mysqli_query($connection, $querySelect);
                            while($row =mysqli_fetch_assoc($result)) {
                                $ticket_id = $row['id'];
                                $category = $row['category'];
                                $today_date = date("Y-m-d");
                                $tomorrow_date = date("Y-m-d", strtotime('tomorrow'));
                                $is_soon = 0;
                                if ($category == "hotels" && ($today_date == $row['hotel_date'] || $tomorrow_date == $row['hotel_date'])) {
                                    $is_soon = 1;
                                } else if (($category == "cinema" || $category == "shows")
                                    && ($today_date == $row['date'] || $tomorrow_date == $row['date'])
                                ) {
                                    $is_soon = 1;
                                } else if (($category == "parks" || $category == "workshops") && ($row['type'] == "oneTimeDate" || $row['type'] == "subscriptionDate")
                                    && $row['info'] == $today_date || $row['info'] == $tomorrow_date
                                ) {
                                    $is_soon = 1;
                                }
                                if($row['is_sold'] == 1) $is_soon = 0;
                                if($is_soon == 1) { //print the row! it's expires soon
                                    echo "<tr class=clickable-row data-href=ticket.php?category=" . $category . "&id=" . $ticket_id . "&soon=1>";
                                    echo "<td>" . $ticket_id . "</td>";
                                    echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . $row['city'] . "</td>";
                                    echo "<td>" . $row['price'] . "</td><td>";
                                    if($category == "hotels") echo "בתי מלון וצימרים";
                                    else if($category == "parks") echo "פארקי שעשועים ומים";
                                    else if($category == "cinema") echo "קולנוע";
                                    else if($category == "shows") echo "הופעות";
                                    else echo "סדנאות וחוגים";
                                    echo "</td><td>";
                                    if($row['notes'] == "") echo "---";
                                    echo $row['notes'] . "</td>";
                                    $is_soon = 0;
                                }
                            }
                            echo "</tbody>";
                        }

                        else if (isset($_GET['category'])) {
                            $category =  $_GET['category'];    //parsing the column names....
                            $querySelect = null;
                            $typeVal = null;
                            $date_compare = null;
                            if($category == "cinema" || $category == "shows") {
                                if(isset($_GET['search'])) {
                                    $search_text = $_GET['search'];
                                    $querySelect = "SELECT id, date, name, city, price, notes, is_sold, DATE_FORMAT(date,'%d/%m/%Y') AS hebDate  FROM tbl_221_tickets NATURAL JOIN tbl_221_shows WHERE is_sold = 0 and category= '$category' and (city like '%$search_text%' or name like '%$search_text%')";
                                }
                                else $querySelect = "SELECT id, date, name, city, price, notes, is_sold, DATE_FORMAT(date,'%d/%m/%Y') AS hebDate  FROM tbl_221_tickets NATURAL JOIN tbl_221_shows WHERE is_sold = 0 and category= '$category'";
                                echo "<th>תאריך&#9662;</th>";
                            }

                            else if($category == "hotels") {
                                if(isset($_GET['search'])) {
                                    $search_text = $_GET['search'];
                                    $querySelect = "SELECT id, date, nights, name, city, price, notes, is_sold, DATE_FORMAT(date,'%d/%m/%Y') AS hebDate FROM tbl_221_tickets NATURAL JOIN tbl_221_hotels WHERE is_sold = 0 and (city like '%$search_text%' or name like '%$search_text%')";
                                }
                                else $querySelect = "SELECT id, date, nights, name, city, price, notes, is_sold, DATE_FORMAT(date,'%d/%m/%Y') AS hebDate FROM tbl_221_tickets NATURAL JOIN tbl_221_hotels WHERE is_sold = 0";
                                echo "<th>תאריך&#9662;</th>
                                <th>מס' לילות&#9662;</th>";
                            }

                            else if($category == "parks" || $category == "workshops") {
                                if(isset($_GET['search'])) {
                                    $search_text = $_GET['search'];
                                    $querySelect = "SELECT id, type, info, name, city, price, notes, is_sold FROM tbl_221_tickets NATURAL JOIN tbl_221_parks WHERE is_sold = 0 and category= '$category' and (city like '%$search_text%' or name like '%$search_text%')";
                                }
                                else $querySelect = "SELECT id, type, info, name, city, price, notes, is_sold FROM tbl_221_tickets NATURAL JOIN tbl_221_parks WHERE is_sold = 0 and category= '$category'";
                                echo "<th class='typeRow'>סוג&#9662;</th>
                                <th>מס' כניסות\תאריך&#9662;</th>";
                            }
                            echo "<th>שם&#9662;</th>
                                <th>עיר&#9662;</th>
                                <th>מחיר &#8362;&#9662; </th>
                                <th>פירוט</th>";
                            echo "</tr></thead><tbody>";    //parsing the data inside the table
                            $result = mysqli_query($connection, $querySelect);
                            while($row =mysqli_fetch_assoc($result)) {
                                if($category == "parks" || $category == "workshops") {
                                    if($row['type'] == "oneTimeDate" || $row['type'] == "subscriptionDate")
                                        $date_compare = $row['info'];
                                    else $date_compare = "0";
                                }
                                else $date_compare = $row['date'];
                                if($date_compare != "0" && is_expired($date_compare)) {continue;}    //if ticket is out-dated - dont display it
                                $ticket_id = $row['id'];
                                echo "<tr class=clickable-row data-href=ticket.php?category=" . $category . "&id=" . $ticket_id . ">";
                                echo "<td>" . $ticket_id . "</td>";
                                if(array_key_exists('hebDate',$row)) {
                                    echo "<td>" . $row['hebDate'] . "</td>";
                                }
                                if(array_key_exists('nights',$row)) {
                                    echo "<td>" . $row['nights'] . "</td>";
                                }
                                if(array_key_exists('type',$row)) {
                                    switch($row['type']) {
                                        case "oneTime":
                                            $typeVal = "חד פעמי ללא הגבלה";
                                            break;
                                        case "numTimes":
                                            $typeVal = "כרטיסייה";
                                            break;
                                        case "oneTimeDate":
                                            $typeVal = "חד פעמי עם תאריך";
                                            break;
                                        case "subscriptionDate":
                                            $typeVal = "מנוי";
                                            break;
                                        default: break;
                                    }
                                    echo "<td class='typeRow'>" . $typeVal . "</td>";
                                }
                                if(array_key_exists('info',$row)) {
                                    $infoVal = $row['info'];
                                    if($row['type'] == "oneTimeDate" || $row['type'] == "subscriptionDate") {
                                        $time = strtotime($infoVal);
                                        $infoVal = date('d/m/Y',$time);
                                    }
                                    echo "<td>" . $infoVal . "</td>";
                                }

                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['city'] . "</td>";
                                echo "<td>" . $row['price'] . "</td>";

                                echo "<td>";
                                if($row['notes'] == "") {
                                    echo "---";
                                }
                                echo $row['notes'] . "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                        }
                        ?>
                    </table>
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