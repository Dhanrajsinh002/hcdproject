function calculateSDSM(sd, n) {
    $.ajax({
        method: 'post',
        url : './php/sampling_distribution_of_sample_mean_calc.php',
        data : {SD : sd, N : n}
    }).done(function (response) {
        console.log(response);
    })
}