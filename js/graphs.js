// graph plotting function



// calculation functions

function calculateMethod1(textarea0_value) {
    $.ajax({
        method: "post",
        url: "./php/graphs.php",
        data: {m1_data : textarea0_value}
    }).done(function (response) {
        $("#result").html(response);
        // console.log(response);
    })
}

function calculateMethod2(textarea1_value,textarea2_value) {
    $.ajax({
        method: "post",
        url: "./php/graphs.php",
        data: {m2_label : textarea1_value, m2_data : textarea2_value}
    }).done(function (response) {
        // window.alert(response);
        $("#result").html(response);
    })
}