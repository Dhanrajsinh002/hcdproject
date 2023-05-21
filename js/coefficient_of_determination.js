function calculateCD(X, Y) {
    $.ajax({
        method: "post",
        url: "./php/coefficient_of_determination.php",
        data: {x : X, y : Y}
    }).done(function (response) {
        // console.log(response);
        $("#cd_result").html(response);
    })
}