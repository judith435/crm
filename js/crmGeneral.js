var crmGeneral = (function() {
    var app = {
        debugMode: true,   
        crmApi: 'http://localhost:8080/joint/crm/server/crmAPI.php',
        //crmApi: 'http://localhost/crm/server/crmAPI.php',
        //crmApi: 'http://localhost/joint/crm/server/crmAPI.php',
    }


    jQuery(document).ready(function($) {
        switch ($('title').text()) {
            case "Show Leads":
                Show_Leads();
                break;
            case "Create Lead":
                Get_Products();
                $.ajax('../templates/create-lead-template.html').done(function(data) {
                    $('#CreateUpdateDiv').prepend(data);
                });
                 break;
            case "Update Lead":
                Update_Lead();
                break;
            case "Delete Lead":
                Delete_Lead();
                break;
        }
    });


    function Show_Leads(){
        $("#LeadsTable").load("../templates/leads-table-template.html");

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
                    var cl = CreateLead();
                    for (let i = 0; i < data.length; i++) {
                        leadsArray.push(new cl.Lead(data[i].id, 
                                                        data[i].lead_name,
                                                        data[i].lead_phone,
                                                        data[i].product_id,
                                                        data[i].product_name,
                                                        ));
                    }      
                    $.ajax('../templates/lead-template.html').done(function(data) {
                        $("#leads").html("");
                        for(let i=0; i < leadsArray.length; i++) {
                            let template = data;
                            template = template.replace("{{id}}", leadsArray[i].id);
                            template = template.replace("{{lead_name}}", leadsArray[i].lead_name);
                            template = template.replace("{{lead_phone}}", leadsArray[i].lead_phone);
                            template = template.replace("{{product_id}}", leadsArray[i].product_id);
                            template = template.replace("{{product_name}}", leadsArray[i].product_name);
                            $('#leads').append(template);
                        }
                    });
            });
    }
    
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
                // $("#ProductDDL").append(new Option(data[i].name, data[i].id + ',' + data[i].name));
                $("#ProductDDL").append(new Option(data[i].name, data[i].id));
            }
        });
    }

    function Update_Lead(){
        $("#btnUpdateLead , #leadTitle").hide();
        Show_Leads();
        $(document).on('click','#LeadsTable tr',function(e){
            var leadNumber = $(this).find('td:first').text();
            var leadName = $(this).find('td:nth-child(2)').text();
            var leadPhone = $(this).find('td:nth-child(3)').text();
            var productID = $(this).find('td:nth-child(4)').text();
            var productName = $(this).find('td:nth-child(5)').text();
            var cl =  CreateLead();
            console.log(cl);
            var lead = new cl.Lead( leadNumber, 
                                    leadName,
                                    leadPhone,
                                    productID,
                                    productName);
            $.ajax('../templates/create-lead-template.html').done(function(data) {
                $("#CreateUpdateDivFields").html(""); 
                $('#CreateUpdateDivFields').prepend(data);
                $('#leadName').attr("value", lead.lead_name);
                $('#leadPhone').attr("value", lead.lead_phone);
                $('#leadID').attr("value", lead.id);
                $("#leadTitle").text("Lead# being updated: " + lead.id).show();
                $("#btnUpdateLead").show();
                Get_Products();
                //$("#ProductDDL").val(lead.product_id);
            });
            console.log($("#ProductDDL"));
            console.log($("#ProductDDL").val);
            $("#ProductDDL").val("9");


        })
    }

    function Delete_Lead(){
        Show_Leads();
        $(document).on('click','#LeadsTable tr',function(e){
            var leadNumber = $(this).find('td:first').text();
            var confirmation = confirm('Are you sure you want to delete lead number ' + leadNumber + "?");
            if (confirmation == true) {
                var asp = new AjaxSubmitParms("delete", "lead", leadNumber)
                ajaxSubmit(asp);
            } 
            else {
                alert("You pressed Cancel!");
            }
         })
        }


    //write same generic add functionfor all crm objects
    $('#frmCUD').on("submit", function (e) {   
        e.preventDefault();
    });

    function AjaxSubmitParms(action, entity, id) {
        this.action = action;
        this.entity = entity;
        this.id = id;
    }

    function ajaxSubmit(asp){
        if (asp.action == "delete"){
            var ajaxData = asp;
        }
        else {
            var ajaxData =  $('form').serialize();
        }
        $.ajax({
            type: "POST",
            url:  app.crmApi,
            data:  ajaxData,
            success: function(data){
                if (app.debugMode) {
                    console.log("crmApi response");
                    console.log(data);
                }
                data = JSON.parse(data);
                // data.message conatains CUD confirmation if successful or application errors => e.g. missing product if not
                alert(data.status + " " + data.action + " " + data.message); 
                if(data.status == 'error') { return; }
                if(data.action == "delete" || data.action == "UpdateLead" ){ //if action was delete update show new entitiy table
                    Show_Leads();
                    // switch (asp.entity) { => for future use
                    //     case "lead":
                    //         Show_Leads();
                    //         break;
                    // }
                }
                if(data.action == "UpdateLead") {
                    $("#CreateUpdateDivFields").html("");  
                    $("#btnUpdateLead , #leadTitle").hide();
                }
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

