function calculateOPMKS(NH, SL, SM, SD, SS, C) {
    let sig = SL / 100;
    let CI_ALPHA =  Math.abs(jStat.normal.inv(sig, 0, 1)).toFixed(3);
    $.ajax({
        method: 'post',
        url: './php/one_population_mean_known_sigma.php',
        data: {nh : NH, sl : SL, sm : SM, sd : SD, ss : SS, c : C, ci_alpha : CI_ALPHA}
    }).done(function (response) {
        // console.log(response);
        $("#opmsk_res").html(response);
    })
}