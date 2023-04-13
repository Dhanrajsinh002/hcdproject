function calculateSEAD(lbl, val, grp) {
    $.ajax({
        method : 'post',
        url : './php/sampling_error_and_distribution.php',
        data : {LBL : lbl, VAL : val, GRP : grp}
    }).done(function (response) {
        // $("#sed_res").html(response);
        console.log(response);
    })
}