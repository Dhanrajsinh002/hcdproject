function calculateNDV(mean, sd, p, conditions) {
    $.ajax({
        method: 'post',
        url: './php/working_with_normally_distributed_variable.php',
        data: {Mean : mean, SD : sd, P : p, Conditions : conditions}
    }).done(function (response) {
        console.log(response);
    })
}