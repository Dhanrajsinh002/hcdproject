function calculatePDHMethod1(val) {
    // alert(val);
    $.ajax({
        method: 'post',
        url: './php/probability_distribution_histogram.php',
        data: {pdh_val : val}
    }).done(function (response) {
        alert(response);
    })
}

function calculatePDHMethod2(lbl,val) {
    // alert(val);
    $.ajax({
        method: 'post',
        url: './php/probability_distribution_histogram.php',
        data: {pdh_lbl : lbl, pdh_lbl_val : val}
    }).done(function (response) {
        // alert(response);
        $("#result").html(response);
    })
}