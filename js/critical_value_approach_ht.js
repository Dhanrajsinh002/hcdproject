function calculateCVHT(NH, SL, SM, SD, SS, C) {
    let sig = SL / 100;
    let CI_ALPHA =  Math.abs(jStat.normal.inv(sig, 0, 1)).toFixed(3);
    $.ajax({
        method: 'post',
        url: './php/critical_value_approach_ht.php',
        data: {nh : NH, sl : SL, sm : SM, sd : SD, ss : SS, c : C, ci_alpha : CI_ALPHA}
    }).done(function (response) {
        // console.log(response);
        $("#cva_res").html(response);
    });
}