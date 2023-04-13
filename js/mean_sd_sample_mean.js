function calculateMSDSM(lbl, val, ss) {
    $.ajax({
        method : 'post',
        url : './php/mean_sd_sample_mean.php',
        data : {LBL : lbl, VAL : val, SS : ss}
    }).done(function (response) {
        // console.log(response);
        $("#msdsm_res").html(response);
    })
}