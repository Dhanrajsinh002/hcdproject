function calculateFNS(val) {
    // alert(val);
    $.ajax({
        method: 'post',
        url: './php/five_number_summary.php',
        data: {fns_val : val}
    }).done(function (response) {
        // window.alert(response);
        console.log(response);
        $("#fns_res").html(response);
    })
}