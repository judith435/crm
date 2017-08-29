$(document).ready(function () {
  validator = $("#frmCUD").validate({
    rules:  {
      leadName: {
        required: true,
        minlength: 3 
        // letters: true
      },
      leadPhone: {
        required: true,
        minlength: 9 
      // numbers: true
      }
    } ,
    messages: {
        leadName: "Please specify your name",
        leadPhone: "Please specify a valid phone#"
    },
    submitHandler: function() {
        var wowo = 4;
        wowo = 5;
        crmGeneral.ajaxSubmit();
      }
  });
});
