function calculateRE(X, Y) {
    $.ajax({
        method: 'post',
        url: './php/regression_equation.php',
        data: {x : X, y : Y}
    }).done(function (response) {
        // alert(response);
        console.log(response);
        $("#re_result").html(response);
        furtherProcess();
    })
}

function claculateYHat(B0, SIGN, B1, X1, X2) {
    // alert(B0, SIGN, B1, X1, X2);
    $.ajax({
        method: 'post',
        url: './php/regression_equation.php',
        data: {b0 : B0, sign : SIGN, b1 : B1, x1 : X1, x2: X2}
    }).done(function (response) {
        // $("#comboPlot").html(response);
        alert(response);
        console.log(response);
    })
}