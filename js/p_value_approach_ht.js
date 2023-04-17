function calculatePVHT(NH, SL, SM, SD, SS, C) {
    $.ajax({
        method: 'post',
        url: './php/p_value_approach_ht.php',
        data: {nh : NH, sl : SL, sm : SM, sd : SD, ss : SS, c : C}
    }).done(function (response) {
        // console.log(response);
        $("#result").html(response);
    })
}