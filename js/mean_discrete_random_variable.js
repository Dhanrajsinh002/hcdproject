function calculateMSDRVM1(val) {
    $.ajax({
        method: 'post',
        url: './php/mean_discrete_random_variable.php',
        data: {msdrv_val : val}
    }).done(function (response) {
        alert(response);
    })
}