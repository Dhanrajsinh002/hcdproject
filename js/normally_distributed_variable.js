function calculateNDV(lbl, val) {
    $.ajax({
        method: 'post',
        url: './php/normally_distributed_variable.php',
        data: {LBL : lbl, VAL : val}
    }).done( function (response) {
        console.log(response);
    })
}