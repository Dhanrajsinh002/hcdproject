// let CI_ALPHA = Math.abs(jStat.studentt.inv(sig, n-1)).toFixed(3);
function calculateCIOPMUSM1(SM, N, SSD ,CI) {
    let sig = ((1 - (CI / 100)) / 2).toFixed(3);
    let CI_ALPHA = Math.abs(jStat.studentt.inv(sig, N-1)).toFixed(3);
    $.ajax({
        method: 'post',
        url: './php/confidence_interval_one_population_mean_unknown_sigma.php',
        data: {sm : SM, n : N, ssd : SSD, ci : CI, ci_alpha : CI_ALPHA}
    }).done(function (response) {
        // console.log(response);
        $("#result").html(response);
    })
}

function calculateCIOPMUSM2(VAL, SSD, CI) {
    let sig = ((1 - (CI / 100)) / 2).toFixed(3);
    let CI_ALPHA = Math.abs(jStat.studentt.inv(sig, (VAL.split(",").length) -1)).toFixed(3);
    $.ajax({
        method: 'post',
        url: './php/confidence_interval_one_population_mean_unknown_sigma.php',
        data: {val : VAL, ssd : SSD, ci : CI, ci_alpha : CI_ALPHA}
    }).done(function (response) {
        // console.log(response);
        $("#result").html(response);
    })
}