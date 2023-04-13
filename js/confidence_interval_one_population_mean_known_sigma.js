function calculateCIOPMKSM1(SM, N, PSD, CI) {
    let sig = (1 - (CI / 100)) / 2;
    let CI_ALPHA =  Math.abs(jStat.normal.inv(sig, 0, 1)).toFixed(2);
    $.ajax({
        method: 'post',
        url: './php/confidence_interval_one_population_mean_known_sigma.php',
        data: {sm : SM, n : N, psd : PSD, ci_alpha : CI_ALPHA, ci : CI}
    }).done(function (response) {
        // console.log(response);
        $("#result").html(response);
    })
}

function calculateCIOPMKSM2(VAL, PSD, CI) {
    let sig = (1 - (CI / 100)) / 2;
    let CI_ALPHA =  Math.abs(jStat.normal.inv(sig, 0, 1)).toFixed(2);
    $.ajax({
        method: 'post',
        url: './php/confidence_interval_one_population_mean_known_sigma.php',
        data: {val : VAL, psd : PSD, ci_alpha : CI_ALPHA, ci : CI}
    }).done(function (response) {
        // console.log(response);
        $("#result").html(response);
    })
}