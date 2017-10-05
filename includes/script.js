$("document").ready(function() {

    if ($(window).width() > 740) {      //User is in Desktop mode
        $("#userPanel").find("> li:last-child").hover(function() {

            $(this).find("#userPanelSettings").stop().slideToggle(400);
        });

        $("#mainMenu").find("> li:nth-child(2)").hover(function() {

            // event.preventDefault();
            $(this).find("#allTicketsList").stop().slideToggle();
        });
    }
    else {
        $("#mainMenu").find("> li:nth-child(2) > a").click(function(event) {

            event.preventDefault();
            $(this).parent().find("#allTicketsList").stop().slideToggle();
        });
    }

    var categoriesMenu = $("#allTicketsList");
    var categoriesSearch = $("#category");
    $.getJSON("data/categories.json", function (data) {
        $.each(data, function(k, v) {

            var listItem = $("<li></li>");
            var optionItem = $("<option></option>");
            var url = "select_ticket.php?category=" + v.value;
            var listAnchor = $("<a href="+url+"></a>").text(v.name);
            listItem.append(listAnchor);
            categoriesMenu.append(listItem);
            optionItem.text(v.name);
            optionItem.attr("value", v.value);
            categoriesSearch.append(optionItem);

        })
    });

    if ($(window).width() > 740) {      //User is in Desktop mode
        $("#ticketNumberDialog").each(function() {       /*Displaying the num of tickets grows up - will be fixed later */
            var $this = $(this),
                countTo = $this.attr('data-count');

            $({ countNum: $this.text()}).animate({
                    countNum: countTo
                },

                {
                    duration: 1500,
                    easing:'linear',
                    step: function() {
                        $this.text(Math.floor(this.countNum));
                    },
                    complete: function() {
                        $this.text(this.countNum);
                    }
                });
        });
    }

    $("#searchForm").submit(function(/*event*/) {
        var ticketCategory = $("#category").val();
        var searchText = $("#searchText").val();
        if(searchText == "" || ticketCategory == null) return false;  //Must be non-empty
        window.location = "select_ticket.php?category=" + ticketCategory + "&search=" + searchText;
        return false;
    });
});