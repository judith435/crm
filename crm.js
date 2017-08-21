var app = {
    debugMode: true,   
    crmApi: 'http://localhost/joint/crm/crmAPI.php',
}

jQuery(document).ready(function($) {
    switch ($('title').text()) {
        case "Show Leads":
            Show_Leads();
            break;
        case "Show Prospects":
            Show_Prospects();
            break;
    }
});

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
        //data = JSON.parse(data);
        var stringi = JSON.stringify(data);
        $("#content").text(stringi);
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


{/* <script>
  $('#saveBtn').button().click(function(e) {
    e.preventDefault();
    var targetUrl = 'update_gallery_grid.php?propertyid=' + propertyid + '&product=' + product + '&payment=' + payment;
    $.ajax({
      url: targetUrl,
      type: 'post',
      data: {
        json: JSON.stringify(order)
      },
      success: function(result) {
        $('#result').html("<p>Order: " + order + "</p><p>Results: " + result + "</p>");
      },
      error: function(xhr, status, error) {
        $('#result').append("<p>" + error + "</p>");
      }
    });
  });

  $('#sortable').sortable({
    placeholder: "ui-state-highlight",
    update: function(event, ui) {
      order = $(this).sortable('serialize');
    }
  });
  $("#sortable").disableSelection();

  var order = $('#sortable').sortable('serialize');
  </script> */}