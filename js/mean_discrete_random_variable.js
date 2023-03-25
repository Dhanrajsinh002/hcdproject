function calculateMSDRVM1(val) {
    $.ajax({
        method: 'post',
        url: './php/mean_discrete_random_variable.php',
        data: {msdrv_val : val}
    }).done(function (response) {
        // console.log(response);
        $("#msdrv_res").html(response);
    })
}

function calculateMSDRVM2(lbl,val) {
    $.ajax({
        method: 'post',
        url: './php/mean_discrete_random_variable.php',
        data: {m2_msdrv_lbl_val : lbl, m2_msdrv_val : val}
    }).done(function (response) {
        // alert(response);
        $("#msdrv_res").html(response);
    })
}