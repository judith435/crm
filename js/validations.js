$(document).ready(function () {
  // 1. prepare the validation rules and messages.
  var rules = {
      leadName: {
        required: true,
        minlength: 3,
        letters: true
      },
      leadPhone: {
        required: true,
        minlength: 9,
      // numbers: true
      }
  };
  var messages = {
      leadName: "Please specify your name (only letters and spaces are allowed)",
      leadPhone: "Please specify a valid phone#"
};

  // 2. Initiate the validator
  var validator = new jQueryValidatorWrapper("frmCUD", rules, messages);
  function kuku(){
    if (!validator.validate())
        return;
  
    alert("Validation Success!");
  };

  // 3. Set the click event to do the validation     $('#frmCUD').on("submit", function (e) {   
  // $("#btnValidate").click(function () {
});



(function() {
  
  function Validate(){
    var $form = $("form"),
          $successMsg = $(".alert");
          $.validator.addMethod("letters", function(value, element) {
              return this.optional(element) || value == value.match(/^[a-zA-Z\s]*$/);
          });
    $form.validate({
      rules: {
          leadName: {
          required: true,
          minlength: 3,
          letters: true
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
  }
})();
