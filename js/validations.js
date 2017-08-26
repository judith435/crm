(function() {
    var $form = $("form"),
        $successMsg = $(".alert");
        // $.validator.addMethod("letters", function(value, element) {
        //     return this.optional(element) || value == value.match(/^[a-zA-Z\s]*$/);
        // });
  $form.validate({
    rules: {
        leadName: {
        required: true,
        minlength: 3
        // letters: true
      },
      leadPhone: {
        required: true,
        minlength: 9,
        // numbers: true
      }
    },
    messages: {
      leadName: "Please specify your name (only letters and spaces are allowed)",
      leadPhone: "Please specify a valid phone#"
    },
    submitHandler: function() {
      $successMsg.show();
    }
  });
})();
