<?php include('includes/session.php');?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1, maximum-scale=1, user-scalable=0">
        <title>TikTicket</title>
        <link rel="icon" href="images/icons/logo_icon.png">
        <script src="includes/jquery-3.1.1.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Varela+Round&amp;subset=hebrew" rel="stylesheet">
        <link rel="stylesheet" href="includes/stylesheet.css">
        <script src="includes/script.js"></script>
        <?php include('includes/db_connection.php');?>
    </head>
    <body id="index">
        <div id="wrapper">
            <header>
                <a id="logo" href="#"></a>
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
                        <a href="select_category.php"> כל הכרטיסים <span>&#9662;</span> </a>
                        <ul id="allTicketsList"></ul>
                    </li>
                    <li><a href="sell_ticket.php">מכירת כרטיס</a></li>
                    <li><a href="#">איך זה עובד</a></li>
                </ul>
            </nav>
            <main id="homePage">
                <section></section>
                <section></section>
                <article class="orangeHalfPage">
                    <a href="select_category.php">רכישת כרטיס</a>
                    <section id="ticketNumberSection">
                        <h3>כרגע במערכת</h3>
                        <section>
                            <?php
                            $query_count = "SELECT COUNT(*) as sum FROM tbl_221_tickets WHERE is_sold=0";
                            $result = mysqli_query($connection, $query_count);
                            $row =mysqli_fetch_assoc($result);
                            $num_tickets = $row['sum'];
                            echo "<p id=ticketNumberDialog data-count=" . $num_tickets . "></p>"; ?>
                        </section>
                        <h3>כרטיסים</h3>
                    </section>

                   <section id="orangeTextContainer">
                    <h3>רכוש כרטיס במחיר משתלם במיוחד</h3>
                    <p>
                        לורם איפסום דולור סיט אמט, קונסקטורר אדיפיסינג אלית נולום ארווס סאפיאן - פוסיליס קוויס, אקווזמן סחטיר בלובק.
                        תצטנפל בלינדו למרקל אס לכימפו, דול, צוט ומעיוט - לפתיעם ברשג - ולתיעם גדדיש. קוויז דומור
                        ליאמום בלינך רוגצה.
                        לפמעט מוסן מנת. לפרומי בלוף קינץ תתיח לרעח. לת צשחמי צש בליא, מנסוטו צמלח לביקו ננבי
                        , צמוקו בלוקריה שיצמה ברורק. קוואזי במר מודוף. אודיפו בלאסטיק מונופץ קליר, בנפת נפקט למסון בלרק
                        לת צשחמי צש בליא, מנסוטו צמלח לביקו ננבי, צמוקו בלוקריה שיצמה ברורק
                    </p>
                   </section>
                </article>

                <article class="blueHalfPage">
                    <h1>ברוכים הבאים!</h1>
                    <h3>מכור את כרטיסך בקלות וללא עלות</h3>
                    <p>
                                                                    לורם איפסום דולור סיט אמט, קונסקטורר אדיפיסינג אלית נולום ארווס סאפיאן - פוסיליס קוויס,
                                                                    אקווזמן סחטיר בלובק. תצטנפל בלינדו למרקל אס לכימפו, דול, צוט ומעיוט - לפתיעם ברשג - ולתיעם גדדיש.
                                                                    קוויז דומור ליאמום בלינך רוגצה. לפמעט מוסן מנת. לפרומי בלוף קינץ תתיח לרעח. לת צשחמי צש בליא, מנסוטו צמלח
                                                                    לביקו ננבי, צמוקו בלוקריה שיצמה ברורק. קוואזי במר מודוף. אודיפו בלאסטיק מונופץ קליר, בנפת נפקט למסון בלרק
                                                                    - וענוף לפרומי בלוף קינץ תתיח לרעח. לת צשחמי צש בליא, מנסוטו צמלח לביקו ננבי, צמוקו בלוקריה שיצמה ברורק
                    </p>
                    <section id="orangeButtonContainer"><a href="sell_ticket.php">מכירת כרטיס</a></section>
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