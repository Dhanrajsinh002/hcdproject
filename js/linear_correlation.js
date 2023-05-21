function calculateLC(X, Y) {
    $.ajax({
        method: "post",
        url: "./php/linear_correlation.php",
        data: {x : X, y : Y}
    }).done(function (response) {
        // console.log(response);
        $("#lc_result").html(response);
    })
}