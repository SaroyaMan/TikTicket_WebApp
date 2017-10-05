$("document").ready(function() {

    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    };
    var categoryValue = getUrlParameter('category');
    var soon = getUrlParameter('soon');
    var mine = getUrlParameter('mine');
    //Update the breadcrumbs and the h3
    $.getJSON("data/categories.json", function (data) {
        $.each(data, function(k, v) {
            if(v.value == categoryValue) {       //true should be replaced with the URL param
                $("#selectTicket").find("> h1").text(v.name);
                if(soon != 1 && mine != 1)
                    $("#breadCrumbs").find("> li:nth-child(3) > a").text(v.name);
                $("#singleTicketCategory").attr("href", "select_ticket.php?category="+v.value).text(v.name);
                return false;
            }
        })
    });

    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });


    var table = $("#tableCategories");
    table.tablesorter();
    var rowCount = table.find("tr").length-1; //decrement the table header
    if(!rowCount)
        $("#ticketSimilar").hide();


    // Get the modal
    var modal = document.getElementById('myModal');
    var alertBox = $("#alert");
    var buttonPayNow = $("#payNow"), buttonAddCart = $("#addToCart"), loader = $("#loaderContent");
    buttonPayNow.click(function(/*event*/) {
        loader.fadeIn(300);
        var ticketId = $("#ticketId").text();
        var ticketIsSold;
        var dataString = 'id=' + ticketId;
        $.ajax({
            type: "POST",
            url: "includes/download_ticket.php",
            data: dataString,
            cache: true,
            success: function(data){
                loader.fadeOut(300);
                console.log(data);
            },
            error: function(data) {
                console.log(data);
            }
        }).done(function (data, textStatus, xhr) {
            ticketIsSold = parseInt(data);
            if(ticketIsSold == 2) modal.style.display = "block";
            else if(ticketIsSold == 1) {
                alertBox.show();
                buttonPayNow.css("display", "none");
                buttonAddCart.css("display", "none");
            } else {
                console.log("Unknown Error!");
            }
        });
    });
});