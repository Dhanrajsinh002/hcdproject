function calculatey(intercept, slop) {
    $.ajax({
        method: 'post',
        url: './php/linear_equation_with_one_independant_variable.php',
        data: {Intercept : intercept, Slop : slop}
    }).done(function (response) {
        $("#y_res").html(response);
    })
}