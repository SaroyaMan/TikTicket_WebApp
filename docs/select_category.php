<?php include('includes/session.php');?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1, maximum-scale=1, user-scalable=0">
        <title>TikTicket - Select Category</title>
        <link rel="icon" href="images/icons/logo_icon.png">
        <script src="includes/jquery-3.1.1.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Varela+Round&amp;subset=hebrew" rel="stylesheet">
        <link rel="stylesheet" href="includes/stylesheet.css">
        <script src="includes/script.js"></script>
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
                    <li><a href="select_ticket.php?soon=1">כרטיסים ליממה הקרובה</a></li>
                    <li>
                        <a href="#" class="mainSelected"> כל הכרטיסים <span>&#9662;</span> </a>
                        <ul id="allTicketsList"></ul>
                    </li>
                    <li><a href="sell_ticket.php">מכירת כרטיס</a></li>
                    <li><a href="#">איך זה עובד</a></li>
                </ul>
            </nav>
            <main>
                <article id="buyTickets">
                    <ul id="breadCrumbs">
                        <li><a href="index.php">דף הבית</a>
                            <span class="LeftArrowBreadCrumbs">&#9664;</span>
                        </li>
                        <li><a href="#">בחירת קטגוריה</a></li>
                    </ul>
                    <h1>בחירת קטגוריה</h1>
                    <section id="categories">

                        <section>
                            <a href="select_ticket.php?category=parks">פארקי שעשועים ומים</a>
                        </section>

                        <section>
                            <a href="select_ticket.php?category=shows">הופעות</a>
                        </section>

                        <section>
                            <a href="select_ticket.php?category=cinema">קולנוע</a>
                        </section>

                        <section>
                            <a href="select_ticket.php?category=workshops">סדנאות וחוגים</a>
                        </section>

                        <section>
                            <a href="select_ticket.php?category=hotels">בתי מלון וצימרים</a>
                        </section>
                        <div class="clear"></div>
                    </section>
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