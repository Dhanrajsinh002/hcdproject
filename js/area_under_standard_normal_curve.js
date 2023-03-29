function calculateSNC(z1, z2 = 0, conditions) {
    $.ajax({
        method: 'post',
        url: './php/area_under_standard_normal_curve.php',
        data: {Z1 : z1, Z2 : z2, Conditions : conditions}
    }).done(function (response) {
        console.log(response);
    })
}