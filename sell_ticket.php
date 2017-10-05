<?php include('includes/session.php');?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1, maximum-scale=1, user-scalable=0">
        <title>TikTicket - Sell a ticket</title>
        <link rel="icon" href="images/icons/logo_icon.png">
        <script src="includes/jquery-3.1.1.min.js"></script>

        <!-- JS file -->
        <script src="includes/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.min.js"></script>

        <!-- CSS file -->
        <link rel="stylesheet" href="includes/EasyAutocomplete-1.3.5/easy-autocomplete.min.css">

        <!-- Additional CSS Themes file - not required-->
        <link rel="stylesheet" href="includes/EasyAutocomplete-1.3.5/easy-autocomplete.themes.min.css">

        <link href="https://fonts.googleapis.com/css?family=Varela+Round&amp;subset=hebrew" rel="stylesheet">
        <link rel="stylesheet" href="includes/stylesheet.css">
        <link href="includes/jquery_ui/jquery-ui.min.css" rel="stylesheet">
        <link href="includes/jquery_ui/jquery-ui.theme.min.css" rel="stylesheet">
        <link href="includes/jquery_ui/jquery-ui.structure.min.css" rel="stylesheet">
        <script src="includes/jquery_ui/jquery-ui.min.js"></script>
        <script src="includes/jquery_ui/datepickerHeb.js"></script>
        <script src="includes/script.js"></script>
        <script src="includes/script_sell_ticket.js"></script>
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
                        <a href="select_category.php"> כל הכרטיסים <span>&#9662;</span> </a>
                        <ul id="allTicketsList"></ul>
                    </li>
                    <li class="mainSelected"><a href="#">מכירת כרטיס</a></li>
                    <li><a href="#">איך זה עובד</a></li>
                </ul>
            </nav>
            <main id="sellTickets">
                <article>
                    <ul id="breadCrumbs">
                        <li><a href="index.php">דף הבית</a>
                            <span class="LeftArrowBreadCrumbs">&#9664;</span>
                        </li>
                        <li><a href="#" class="orangeText">מכירת כרטיס</a></li>
                    </ul>
                    <h1>מכירת כרטיס</h1>
                    <form id="uploadTicketForm" method="post" action="">
                        <p>
                            <label>שם הכרטיס<span class="redText">*</span>:</label>
                            <input type="text" name="name" pattern="^[א-תa-zA-Z0-9_ ]*$" title="רק מילים באנגלית ובעברית" id="ticketName" placeholder="למשל סופרלנד" maxlength="64" required>
                        </p>

                        <p>
                            <label>עיר<span class="redText">*</span>:</label>
                            <input type="text" placeholder="למשל ראשון לציון" required id="ticketCities">
                        </p>

                        <p>
                            <label for="ticketPrice">מחיר<span class="redText">*</span>:</label>
                            <input id="ticketPrice" type="number" min="0" max="10000" value="0" step="1" required>
                            <span>₪</span>
                        </p>

                        <p>
                            <label for="ticketCategory">קטגוריה<span class="redText">*</span>:</label>
                            <select id="ticketCategory"></select>
                        </p>

                        <section id="ticketBarcodeWrapper">
                            <label for="ticketBarcode">ברקוד הכרטיס:</label>
                            <div id="fileDiv">
                                <input id="ticketBarcode" type="file" title="Please upload barcode" accept="image/*">
                                <span id='val'></span>
                                <span id='button'></span>
                            </div>
                        </section>

                        <p>
                            <label for="ticketNotes">פירוט:</label>
                            <textarea id="ticketNotes" maxlength="512" placeholder="כתוב כאן פרטים על הכרטיס שלך..."></textarea>
                        </p>

                        <fieldset id="parks">
                            <legend>סדנאות וחוגים, פארקי שעשועים ומים</legend>
                            <span>הכרטיס שברשותי הוא<span class="redText">*</span>:</span>
                            <section>
                                <label>
                                    <input type="radio" name="ticketKind" value="oneTime" checked>
                                    <span>כרטיס כניסה חד-פעמי ללא הגבלה</span>
                                    <input type="number" value="1" id="oneTime" class="none" disabled="disabled">
                                </label>

                                <label>
                                    <input type="radio" name="ticketKind" value="oneTimeDate">
                                    <span>כרטיס כניסה חד-פעמי לתאריך:</span>
                                    <input type="text" class="DateFrom" disabled="disabled" id="oneTimeDate" required readonly>
                                </label>

                                <label>
                                    <input type="radio" name="ticketKind" value="subscriptionDate">
                                    <span>מנוי עד לתאריך:</span>
                                    <input type="text" class="DateFrom" disabled="disabled" id="subscriptionDate" required readonly>
                                </label>

                                <label>
                                    <input type="radio" name="ticketKind" value="numTimes">
                                    <span>כרטיסייה עם מס' כניסות:</span>
                                    <input type="number" min="2" max="100" step="1" disabled="disabled" id="numTimes" required>
                                </label>
                            </section>
                        </fieldset>

                        <fieldset id="hotels">
                            <legend>בתי מלון וצימרים</legend>
                            <section>
                                <p>
                                    <label for="hotelsDate">תאריך<span class="redText">*</span>:</label>
                                    <input type="text" class="DateFrom" id="hotelsDate" required readonly>
                                </p>
                                <p>
                                    <label for="hotelsNight">מס' לילות<span class="redText">*</span>:</label>
                                    <input type="number" min="1" max="50" step="1" value="1" id="hotelsNight" required>
                                </p>
                            </section>
                        </fieldset>

                        <fieldset id="shows">
                            <legend>קולנוע, הופעות</legend>
                            <section>
                                <p>
                                    <label for="showsDate">תאריך<span class="redText">*</span>:</label>
                                    <input type="hidden" class="DateFrom" name="ticketKind" id="showsDate" required readonly>
                                </p>
                            </section>
                        </fieldset>

                        <section id="submitPart">
                            <input type="submit" value="פרסם כרטיס למכירה" id="submitTicket">
                            <p>שים<span>&#10084;</span> משתמשים שממלאים כרטיסים בצורה מדויקת ואמינה, זוכים למכירה בסבירות גבוהה יותר
                            </p>

                            <p>
                                נולום ארווס סאפיאן - פוסיליס קוויס, אקווזמן קוואזי במר מודוף. אודיפו בלאסטיק מונופץ קליר, בנפת נפקט למסון בלרק - וענוף סחטיר בלובק. תצטנפל בלינדו למרקל אס לכימפו, דול, צוט ומעיוט - לפתיעם ברשג - ולתיעם גדדיש. קוויז דומור ליאמום בלינך רוגצה. לפמעט מוסן מנת. קולורס מונפרד אדנדום סילקוף, מרגשי ומרגשח. עמחליף קולהע צופעט למרקוח איבן איף, ברומץ כלרשט מיחוצים. קלאצי סחטיר בלובק. תצטנפל בלינדו למרקל אס לכימפו, דול, צוט ומעיוט - לפתיעם ברשג - ולתיעם גדדיש. קוויז דומור ליאמום בלינך רוגצה. לפמעט
                            </p>
                        </section>
                    </form>
                    <!-- The Modal -->
                    <div id="myModal" class="modal">

                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <!--<span class="close">&times;</span>-->
                                <a href="index.php" id="logo_lightbox"></a>   <!-- Logo will be here -->
                            </div>
                            <div class="modal-body">
                                <h1>הכרטיס פורסם במערכת</h1>
                                <p> קולורס מונפרד אדנדום סילקוף, מרגשי ומרגשח. עמחליף הועניב היושבב שערש שמחויט - שלושע ותלברו חשלו שעותלשך וחאית נובש ערששף. זותה מנק הבקיץ אפאח דלאמת יבש, כאנה ניצאחו נמרגי שהכים תוק, הדש שנרא התידם הכייר וק</p>
                                <a href="index.php">בחזרה לדף הבית</a>
                                <a href="sell_ticket.php">מכירת כרטיס נוסף</a>
                                <p>קולורס מונפרד אדנדום סילקוף, מרגשי ומרגשח. עמחליף הועניב היושבב שערש שמחוי - שלושע ותלברו חשלו שעותלשך וחאית נובש ערששף. זותה מנק הבקיץ אפאח דלאמת יבש, כאנה ניצאחו נמרגי שהכים תוק, הדש שנרא התידם הכייר וק</p>
                            </div>
                            <!--<div class="modal-footer">-->
                            <!--<h3>Modal Footer</h3>-->
                            <!--</div>-->
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