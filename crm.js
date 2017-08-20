var app = {
    debugMode: false,  //true,
    crmApi: 'http://localhost:8080/joint/crm/crmAPI.php'

}

jQuery(document).ready(function($) {
    if ( $('h1').text() == 'Main Page' ) {
        $('nav').hide();
        $('#welcome').show();
    } else {
        // something ...
    }
});

$.ajax({    
            type: 'POST',
            url: app.crmApi,
            data: {action: 'getLeads'},
       })
        .done(function(data) {
    if (app.debugMode) {
        console.log("crmApi response");
        console.log(data);
    }
    //data = JSON.parse(data);
    var stringi = JSON.stringify(data);
    $("#leads").text(stringi);
    // for(let i=0; i < data.length; i++) {
    //     var ttt = i;
    //       $("#leads").append(data[i]);

    // }
});

