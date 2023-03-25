function calculateBinomialProbability(N,P,X,O) {
    $.ajax({
        method: 'post',
        url: './php/binomial_distribution.php',
        data: {bd_n : N, bd_p : P, bd_x : X, bd_o : O}
    }).done(function (response) {
        // alert(response);
        $("#bd_result").html(response);
    })
}