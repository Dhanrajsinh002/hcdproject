function estimatePMM1(SM, SS, PSD, CI) {
    $.ajax({
        method: 'post',
        url: './php/estimating_population_mean.php',
        data: {sm : SM, ss : SS, psd : PSD, ci : CI}
    }).done(function (response) {
        // console.log(response);
        $("#result").html(response);
    })
}

function estimatePMM2(VAL, PSD, CI_VAL) {
    $.ajax({
        method: 'post',
        url: './php/estimating_population_mean.php',
        data: {val : VAL , psd : PSD , ci_val : CI_VAL}
    }).done(function (response) {
        // console.log(response);
        $("#result").html(response);
    })
}