// let CI_ALPHA = Math.abs(jStat.studentt.cdf(3.458, 14)); // for p-value approach
// let CI_ALPHA = Math.abs(jStat.studentt.inv(0.05, 14)); // for critical value approach
function calculateOPMUS(NH, SL, SM, SSD, SS, C) {
    // let cv_sig = (SL / 100);
    // let CV = Math.abs(jStat.studentt.inv(cv_sig, SS - 1)).toFixed(3);
    // alert(1 - CI_ALPHA);
    $.ajax({
        method: 'post',
        url: './php/one_population_mean_unknown_sigma.php',
        // data: {nh : NH, sl : SL, sm : SM, ssd : SSD, ss : SS, c : C, cv : CV}
        data: {nh : NH, sl : SL, sm : SM, ssd : SSD, ss : SS, c : C}
    }).done(function (response) {
        console.log(response);
        $("#opmus_res").html(response);
        // calculateP(response, SS, C);
    })
}

// function calculateP(t, n, C) {
//     alert(t+"\n"+n+"\n"+C);
    // let PV = Math.abs(jStat.studentt.cdf(t, n-1));
    // $.ajax({
    //     method: 'post',
    //     url: './php/one_population_mean_unknown_sigma.php',
    //     data: {c : C, pv : PV}
    // }).done(function (response) {
    //     console.log(response);
    //     $("#opmus_res").html(response);
    // })
// }