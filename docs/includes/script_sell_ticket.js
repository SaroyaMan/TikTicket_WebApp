$("document").ready(function() {

    Date.prototype.yyyymmdd = function() {
        var mm = this.getMonth() + 1; // getMonth() is zero-based
        var dd = this.getDate();

        return [this.getFullYear()+'-',
            (mm>9 ? '-' : '0') + mm,
            (dd>9 ? '-' : '0') + dd
        ].join('');
    };
    var todayDate = new Date();

    var options = {
        url: "data/cities.json",

        getValue: "name",

        list: {
            maxNumberOfElements: 10,
            match: {
                enabled: true
            },

            showAnimation: {
                type: "fade", //normal|slide|fade
                time: 400
            },

            hideAnimation: {
                type: "normal", //normal|slide|fade
                time: 1
            }
        }
    };
    $("#ticketCities").easyAutocomplete(options);

    var categories = $("#ticketCategory");
    $.getJSON("data/categories.json", function (data) {
        $.each(data, function(k, v) {
            var categoryItem = $("<option></option>").text(v.name);
            categoryItem.attr('value', v.value);
            categories.append(categoryItem);
        })
    });

    $("input[type='file']").change(function () {
        $('#val').text(this.value.replace(/C:\\fakepath\\/i, ''));
    });

    $("input.DateFrom").datepicker({
        minDate: 0
    });

    //better design - access only one time to the selector...
    var parks = $("#parks"), hotels = $("#hotels"), shows = $("#shows"),
        showsDate = $("#showsDate"), hotelsDate = $("#hotelsDate"), hotelsNight = $("#hotelsNight");
    function hideAllExceptOne(val) {
        if(val == "shows" || val == "cinema") {
            parks.hide();
            hotels.hide();
            shows.show();
            showsDate.attr("type","text");
            hotelsDate.attr("type","hidden");
            hotelsNight.attr("type", "hidden");
        }
        else if(val == "parks" || val == "workshops") {
            shows.hide();
            hotels.hide();
            parks.show();
            showsDate.attr("type","hidden");
            hotelsDate.attr("type","hidden");
            hotelsNight.attr("type", "hidden");
        }
        else {
            parks.hide();
            shows.hide();
            hotels.show();
            showsDate.attr("type","hidden");
            hotelsDate.attr("type","text");
            hotelsNight.attr("type", "text");
        }
    }

    categories.change(function() {
        hideAllExceptOne(this.value);
    });


    var oneTimeUseDate = $("#oneTimeDate");
    var subscriptionDate = $("#subscriptionDate");
    var numTimes = $("#numTimes");
    var rad = $("input[name=ticketKind]");
    for(var i = 0; i < rad.length; i++) {
        rad[i].onclick = function() {
            oneTimeUseDate.prop('disabled', true);
            subscriptionDate.prop('disabled', true);
            numTimes.prop('disabled', true);
            switch(this.value) {
                case "oneTime":
                    oneTimeUseDate.val(todayDate.yyyymmdd()); subscriptionDate.val(todayDate.yyyymmdd()); numTimes.val("");
                    break;
                case "oneTimeDate":
                    oneTimeUseDate.prop('disabled', false);
                    subscriptionDate.val(todayDate.yyyymmdd()); numTimes.val("");
                    break;
                case "subscriptionDate":
                    subscriptionDate.prop('disabled', false);
                    oneTimeUseDate.val(todayDate.yyyymmdd()); numTimes.val("");
                    break;
                case "numTimes":
                    numTimes.prop('disabled', false);
                    oneTimeUseDate.val(todayDate.yyyymmdd()); subscriptionDate.val(todayDate.yyyymmdd());
                    break;
            }
        };
    }

    // Get the modal
    var modal = document.getElementById('myModal');
// Get the button that opens the modal

    var loader = $("#loaderContent");
    $("#uploadTicketForm").submit(function(/*event*/) {
        loader.fadeIn(300);
        var ticketName = $("#ticketName").val();
        var ticketCity = $("#ticketCities").val();
        var ticketPrice = $("#ticketPrice").val();
        var ticketCategory = categories.val();
        var ticketNotes = $("#ticketNotes").val();

        var dataString = 'name=' + ticketName + '&city=' + ticketCity + '&price=' + ticketPrice +
            '&category=' + ticketCategory + '&notes=' + ticketNotes;

        if(ticketCategory == "hotels") {
            dataString += '&date=' + $("#hotelsDate").val() + '&nights=' + $("#hotelsNight").val();
        }
        else if(ticketCategory == "cinema" || ticketCategory == "shows") {
            dataString += '&date=' + $("#showsDate").val();
        }
        else {
            var tickKindVal = $("input[name=ticketKind]:checked").val();
            dataString += '&type=' + tickKindVal + '&info=' + $("#" + tickKindVal).val();
        }
        $.ajax({
            type: "POST",
            url: "includes/upload_ticket.php",
            data: dataString,
            cache: true,
            success: function(){
                loader.fadeOut(300);
            }
        }).done(function () {
            modal.style.display = "block";
        });
        return false;
    });
    $(window).keydown(function(event){      //I don't want users to press enter and submit the ticket!
        if(event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });


    $(".readonly").keydown(function(e){
        e.preventDefault();
    });

    $("#ticketPrice").blur(function () {
        if($(this).val() == "") $(this).val("0");
    });

    $(".DateFrom").datepicker('setDate', todayDate);
});