var app = {
    debugMode: true,   
    crmApi: 'http://localhost:8080/joint/crm/crmAPI.php',
}

jQuery(document).ready(function($) {
    switch ($('title').text()) {
        case "Show Leads":
            Show_Leads();
            break;
        case "Show Prospects":
            Show_Prospects();
            break;
        case "Create Lead":
            Get_Products();
            break;
    }
});

function Get_Products(){
    $.ajax({    
        type: 'POST',
        url: app.crmApi,
        data: {action: 'getProducts'},
    })
    .done(function(data) {
        if (app.debugMode) {
            console.log("crmApi response");
            console.log(data);
        }
        data = JSON.parse(data);
        // step 1
        for(let i=0; i < data.length; i++) {
            $("#ProductDDL").append(new Option(data[i].name, data[i].id + ',' + data[i].name));

        }
    });
}

function Show_Leads(){
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

        data = JSON.parse(data);
        var leadsArray = [];
        for (let i = 0; i < data.length; i++) {
            leadsArray.push(new Lead(data[i].id, 
                                     data[i].lead_name,
                                     data[i].lead_phone,
                                     data[i].product_id,
                                     data[i].product_name,
                                    ));
        }      

        $("#content").text(JSON.stringify(leadsArray));
        // for(let i=0; i < data.length; i++) {
        //     var ttt = i;
        //       $("#leads").append(data[i]);

        // }
    });
}

function Show_Prospects(){
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
        $("#content").text(stringi);
        // for(let i=0; i < data.length; i++) {
        //     var ttt = i;
        //       $("#leads").append(data[i]);

        // }
    });
}

function Lead(id, lead_name, lead_phone, product_id, product_name) {
    this.id = id;
    this.lead_name = lead_name;
    this.lead_phone = lead_phone;
    this.product_id = product_id;
    this.product_name = product_name;
}


  $('#btnAddLead').click(function(e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url:  app.crmApi,
        data: $('fieldset').serialize(),
        success: function(){
          alert("lead added successfully");
        }
      });
    });
