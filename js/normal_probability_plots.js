function calculateNPP(val) {
    // alert(val);
    $.ajax({
        method: 'post',
        url: './php/normal_probability_plots.php',
        data: {values : val}
    }).done(function (response) {
        // console.log(response)
        $("#nppTable").html(response)
    })
}