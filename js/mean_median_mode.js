function calculateMMM(mmm_val) {
    console.log("MMM CALLED");
    $.ajax({
        method: "post",
        url: "./php/mean_median_mode_calculate.php",
        data: {val_arr : mmm_val}
    }).done(function (response) {
        // console.log(response);
        $("#subTable").html(response);
    })
}