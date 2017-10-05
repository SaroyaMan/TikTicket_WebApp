$("document").ready(function() {

    $("#tableCategories").tablesorter();

    var aKeyValue = window.location.search.substring(1).split("&");
    var categoryValue = aKeyValue[0].split("=")[1];
    if(categoryValue == 1) {
        $("#selectTicket").find("> h1").text("כרטיסים ליממה הקרובה");
        $("#lastItemBreadCrumbs").text("כרטיסים ליממה הקרובה");
    }
    else {
        //Update the breadcrumbs and the h3
        $.getJSON("data/categories.json", function (data) {
            $.each(data, function(k, v) {
                if(v.value == categoryValue) {       //true should be replaced with the URL param
                    $("#selectTicket").find("> h1").text(v.name);
                    $("#lastItemBreadCrumbs").text(v.name);
                    return false;
                }
            })
        });
    }

    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});