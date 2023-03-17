function calculateZ(val) {
    $.ajax({
        method: 'post',
        url: './php/standardized_variable.php',
        data: {z_data : val}
    }).done(function (response) {
        // alert(response);
        // console.log(response);
        $("#z_result").html(response);
    })
}