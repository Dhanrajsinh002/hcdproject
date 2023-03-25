function calculatePD(lemda, x, conditions) {
    $.ajax({
        method: 'post',
        url: './php/poisson_distribution.php',
        data: {lmd : lemda, X : x, condition : conditions}
    }).done(function (response) {
        // alert(response);
        $("#pd_res").html(response);
    })
}