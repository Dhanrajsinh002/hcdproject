function calculateMSD(val) {
    $.ajax({
        method: 'post',
        url: './php/population_mean_sd.php',
        data: {msd_data : val}
    }).done(function (response) {
        // alert(response);
        $("#msd_result").html(response);
    })
}