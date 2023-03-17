function calculateMVSD(smvd_text) {
    // window.alert("calucate called!!");
    $.ajax({
        method: "post",
        url: "./php/sample_mean_var_sd.php",
        data: {mvsd_data : smvd_text}
    }).done(function (response) {
        $("#subTable").html(response);
    }).fail(function (response) {
        window.alert("something went wrong!!");
        console.log("something went wrong!!");
    })
}