$("document").ready(function() {

    $('#postedTickets').tablesorter({
        0:{sorter: 'Date'}
    });
    $('#boughtTickets').tablesorter({
        0:{sorter: 'Date'}
    });


    var booleans = document.getElementsByClassName("bool");
    for(var i = 0; i < booleans.length; i++) {
        if(booleans[i].textContent == "0") {
            booleans[i].className = "bool no";
        }
        else {
            booleans[i].className = "bool yes";
        }
        booleans[i].textContent = "";
    }

    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});