function calculateNABV(n, p, x, condition) {
    $.ajax({
        method: 'post',
        url: './php/normal_approximation_binomial_variable.php',
        data: {N : n, P : p, X : x, Condition : condition}
    }).done(function (response) {
        // console.log(response);
        $("#nabv_result").html(response);
    })
}