function calculateBMSD(val_n, val_p) {
    // alert(val_n);
    $.ajax({
        method: 'post',
        url: './php/mean_discrete_binomial_variable.php',
        data: {n_val : val_n, p_val : val_p}
    }).done(function (response) {
        // alert(response);
        $("#bmsd_result").html(response);
    })
}