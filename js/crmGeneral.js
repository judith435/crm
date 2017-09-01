// (function() {
//     // Your code here

//     // Expose to global
//     window['varName'] = varName;
// })();
var crmGeneral = (function() {
    var app = {
        debugMode: true,   
        //crmApi: 'http://localhost:8080/joint/crm/server/crmAPI.php',
        //crmApi: 'http://localhost/crm/server/crmAPI.php',
        crmApi: 'http://localhost/joint/crm/server/crmAPI.php',
    }


    jQuery(document).ready(function($) {
        switch ($('title').text()) {
            case "Show Leads":
                Show_Leads();
                break;
            case "Create Lead":
                Get_Products();
                break;
            case "Delete Lead":
                Delete_Lead();
                break;
            case "Show Prospects":
                Show_Prospects();
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
            for(let i=0; i < data.length; i++) {
                $("#ProductDDL").append(new Option(data[i].name, data[i].id + ',' + data[i].name));
            }
        });
    }

    function Show_Leads(){

        $("#LeadsTable").load("../templates/leads-table.html");

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
                    if (data.status == "error"){ 
                        alert(data.message);
                        return;
                    }
    
                    var leadsArray = [];
                    for (let i = 0; i < data.length; i++) {
                        leadsArray.push(new Lead(data[i].id, 
                                                data[i].lead_name,
                                                data[i].lead_phone,
                                                data[i].product_id,
                                                data[i].product_name,
                                                ));
                    }      

                    $.ajax('../templates/lead-template.html')
                    .done(function(data) {
                        for(let i=0; i < leadsArray.length; i++) {
                            let template = data;
                            template = template.replace("{{id}}", leadsArray[i].id);
                            template = template.replace("{{lead_name}}", leadsArray[i].lead_name);
                            template = template.replace("{{lead_phone}}", leadsArray[i].lead_phone);
                            template = template.replace("{{product_id}}", leadsArray[i].product_id);
                            template = template.replace("{{product_name}}", leadsArray[i].product_name);
                            $('.leads').append(template);
                        }
                    });
            });
    }


    function Delete_Lead(){
        Show_Leads();
        $(document).on('click','#LeadsTable tr',function(e){
            var leadNumber = $(this).find('td:first').text();
            var confirmation = confirm('Are you sure you want to delete lead number ' + leadNumber + "?");
            if (confirmation == true) {
                ajaxSubmit(leadNumber);
            } 
            else {
                alert("You pressed Cancel!");
            }
         })
        Show_Leads();
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

    //write same generic add functionfor all crm objects
    $('#frmCUD').on("submit", function (e) {   
        e.preventDefault();
    });

    function ajaxSubmit(iddi){
        var toto =  $('form').serialize();
        var yu = 9;
        $.ajax({
            type: "POST",
            url:  app.crmApi,
            data:  {action: 'Delete', entity: 'Lead', id : iddi }, //$('form').serialize(),
            success: function(data){
                if (app.debugMode) {
                    console.log("crmApi response");
                    console.log(data);
                }
                data = JSON.parse(data);
                // data.message conatains CUD confirmation if successful or application errors => e.g. missing product if not
                alert(data.message); 
            },
            // systen errors caused by a bad connection, timeout, invalid url  
            error:function(data){
                alert(data); //===Show Error Message====
                }
        });

    }

    //ajaxSubmit is called from submitHandler:  in validator = $("#frmCUD").validate({ from validations.js file
    return {
        ajaxSubmit: ajaxSubmit 
    }
})();

