<?php include('includes/session.php');?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1, maximum-scale=1, user-scalable=0">
        <title>TikTicket - Ticket</title>
        <link rel="icon" href="images/icons/logo_icon.png">
        <script src="includes/jquery-3.1.1.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Varela+Round&amp;subset=hebrew" rel="stylesheet">
        <link rel="stylesheet" href="includes/stylesheet.css">
        <script src="includes/table_sorter/jquery.tablesorter.min.js"></script>
        <script src="includes/script.js"></script>
        <script src="includes/script_ticket.js"></script>
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
                <article id="ticketPage">
                    <?php
                    $category = $_GET['category'];
                    $ticketId = $_GET['id'];
                    $querySelect = "UPDATE tbl_221_tickets SET views=views+1 WHERE id=$ticketId";
                    mysqli_query($connection, $querySelect);
                    if($category == "cinema" || $category == "shows") {
                        $querySelect = "SELECT *, DATE_FORMAT(date,'%d/%m/%Y') AS hebDate  FROM tbl_221_tickets NATURAL JOIN tbl_221_shows WHERE id=$ticketId";
                    }

                    else if($category == "hotels") {
                        $querySelect = "SELECT *, DATE_FORMAT(date,'%d/%m/%Y') AS hebDate FROM tbl_221_tickets NATURAL JOIN tbl_221_hotels WHERE id=$ticketId";
                    }

                    else if($category == "parks" || $category == "workshops") {
                        $querySelect = "SELECT * FROM tbl_221_tickets NATURAL JOIN tbl_221_parks WHERE id=$ticketId";
                    }

                    $result = mysqli_query($connection, $querySelect);
                    $row =mysqli_fetch_assoc($result);
                    $ticketName = $row['name'];
                    ?>
                    <ul id="breadCrumbs">
                        <li><a href="index.php">דף הבית</a>
                            <span class="LeftArrowBreadCrumbs">&#9664;</span>
                        </li>
                        <?php
                        if(isset($_GET['soon'])) {
                            echo "<li><a href='select_ticket.php?soon=1'>כרטיסים ליממה הקרובה</a>
                            <span class='LeftArrowBreadCrumbs'>&#9664;</span></li>";
                        }
                        else if(isset($_GET['mine'])) {
                            echo "<li><a href='my_tickets.php'>הכרטיסים שלי</a>
                            <span class='LeftArrowBreadCrumbs'>&#9664;</span></li>";
                        }

                        else {
                            echo "<li><a href=\"select_category.php\">בחירת קטגוריה</a>
                            <span class=\"LeftArrowBreadCrumbs\">&#9664;</span></li>";
                            echo "<li><a href=select_ticket.php?category=" . $category . "></a>
                            <span class='LeftArrowBreadCrumbs'>&#9664;</span></li>";
                        }
                        ?>
                        <li><a href="#" id="lastItemBreadCrumbs"><?php echo "כרטיס - " . $ticketName;?></a></li>
                    </ul>
                    <h1><?php echo "כרטיס - " . $ticketName;?></h1>

                    <section>
                        <p>מס' כרטיס:</p>
                        <span id="ticketId"><?php echo $row['id'];?></span>
                    </section>

                    <section>
                        <p>מס' צפיות:</p>
                        <span id="ticketId"><?php echo $row['views'];?></span>
                    </section>

                    <section>
                        <p>עיר:</p>
                        <span><?php echo $row['city'];?></span>
                    </section>

                    <section>
                        <p>מחיר &#8362;:</p>
                        <span><?php echo $row['price'];?></span>
                    </section>

                    <section>
                        <p>קטגוריה:</p>
                        <a href="#" id="singleTicketCategory"></a>
                    </section>

                    <section id="sectionInfo">
                        <p>מידע נוסף:</p>
                        <span>
                            <?php
                            if($category == "shows" || $category == "cinema") echo "בתאריך " . $row['hebDate'];
                            if($category == "hotels") echo "בתאריך " .
                                $row['hebDate'] . " ל- " . $row['nights'] . " לילות";
                            if($category == "parks" || $category == "workshops") {
                                $type = $row['type'];
                                $time = strtotime($row['info']);
                                $newformat = date('d/m/Y',$time);
                                if($type == "oneTime") echo "כרטיס כניסה חד-פעמי ללא הגבלה";
                                else if($type == "numTimes") echo "כרטיסייה עם " . $row['info'] . " כניסות";
                                else if($type == "oneTimeDate") echo "כרטיס לתאריך " . $newformat;
                                else echo "מנוי עד לתאריך " . $newformat;
                            }
                            ?>
                        </span>
                    </section>

                    <section id="sectionNotes">
                        <p>פירוט:</p>
                        <span><?php if($row['notes'] =="") echo "---"; echo $row['notes'];?></span>
                    </section>

                    <?php
                    if(!isset($_GET['mine'])) {
                        echo "<section class=\"contactSalerSection\">
                        <p></p>
                        <a id=\"contactSaler\" href=\"#\">פנה למפרסם</a>
                    </section>";
                    }
                    ?>


                    <?php
                    echo "<section id=ticketSimilar><p>אולי יעניין אותך גם:</p>";
                    echo "<table id='tableCategories'><thead><tr><th>שם&#9662;</th><th>עיר&#9662;</th><th>מחיר &#8362;&#9662; </th></tr></thead><tbody>";
                    $querySelect = "SELECT id, name, city, price FROM tbl_221_tickets WHERE id!=$ticketId and is_sold=0 and name='$ticketName' and category='$category'";
                    $result = mysqli_query($connection, $querySelect);
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr class=clickable-row data-href=ticket.php?category=" . $category . "&id=" . $row['id'] . ">";

                        if(array_key_exists('name',$row)) {
                            echo "<td>" . $row['name'] . "</td>";
                        }
                        if(array_key_exists('city',$row)) {
                            echo "<td>" . $row['city'] . "</td>";
                        }
                        if(array_key_exists('price',$row)) {
                            echo "<td>" . $row['price'] . "</td>";
                        }
                    }
                    echo "</tbody></table></section>";
                    ?>
                    <div id="alert">
                        <p><strong> מצטערים! </strong>כרטיס זה כבר נרכש.</p>
                    </div>
                    <?php
                    if(!isset($_GET['mine'])) {
                        echo "<button id=\"addToCart\">הוסף לסל הקניות</button>";
                        echo "<button id=\"payNow\">רכישה מיידית</button>";
                    }
                    ?>

                    <section class="ticketPageParagraph">
                        קונסקטורר אדיפיסינג אלית. סת אלמנקום ניסי נון ניבאה. דס איאקוליס וולופטה דיאם. וסטיבולום אט דולור, קראס אגת לקטוס וואל אאוגו וסטיבולום סוליסי טידום בעליק. קונדימנטום קורוס בליקרה, נונסטי קלובר בריקנה סטום, לפריקך תצטריק לרטי
                        גולר מונפרר סוברט לורם שבצק יהול, לכנוץ בעריר גק ליץ, קולורס מונפרד אדנדום סילקוף, מרגשי ומרגשח. עמחליף קולהע צופעט למרקוח איבן איף, ברומץ כלרשט מיחוצים. קלאצי לורם איפסום דולור סיט אמט, גולר מונפרר סוברט לורם שבצק יהול, לכנוץ בעריר גק ליץ, ושבעגט ליבם סולגק. בראיט ולחת צורק מונחף, בגורמי מגמש. תרבנך וסתעד לכנו סתשם השמה - לתכי מורגם בורק? לתיג ישבעס
                    </section>
                    <!-- The Modal -->
                    <div id="myModal" class="modal">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1>הכרטיס נרכש בהצלחה!</h1>
                            </div>
                            <div class="modal-body">
                                <a href="index.php">דף הבית</a>
                                <a href="select_category.php">רכישת כרטיס נוסף</a>
                                <a href="#">מעבר לתשלום</a>
                                <p> לורם איפסום דולור סיט אמט, קונסקטורר אדיפיסינג אלית קולהע צופעט למרקוח איבן איף, ברומץ כלרשט מיחוצים. קלאצי קולורס מונפרד אדנדום סילקוף, מרגשי ומרגשח. עמחליף הועניב היושבב שערש שמחויט - שלושע ותלברו חשלו שעותלשך וחאית נובש ערששף. זותה מנק הבקיץ אפאח דלאמת יבש, כאנה ניצאחו נמרגי שהכים תוק, הדש שנרא התידם הכייר וק</p>
                            </div>
                        </div>
                    </div>
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
        <div id="loaderContent">
            <div id="loader"></div>
        </div>
    </body>
</html>