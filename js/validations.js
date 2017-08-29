$(document).ready(function () {
  validator = $("#frmCUD").validate({
    invalidHandler: function(e, validator) {
			var errors = validator.numberOfInvalids();
			if (errors) {
		  	alert("not ok");
      } 
      else {
		  	alert("all ok");
			}
		},
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
        leadName: "Please specify your name (only letters and spaces are allowed)",
        leadPhone: "Please specify a valid phone#"
    },
    getReturnCode: function() {
      return   validationOK;
  }
  // set this class to error-labels to indicate valid fields
   // success: function(label) {
      // set &nbsp; as text for IE
      //alert("success!");
      // label.html("&nbsp;").addClass("checked");
    //} 
  });
});

// var validator = $("#signupform").validate({
//   rules: {
//     firstname: "required",
//     lastname: "required",
//     username: {
//       required: true,
//       minlength: 2,
//       remote: "users.action"
//     },
//     password: {
//       required: true,
//       minlength: 5
//     },
//     password_confirm: {
//       required: true,
//       minlength: 5,
//       equalTo: "#password"
//     },
//     email: {
//       required: true,
//       email: true,
//       remote: "emails.action"
//     },
//     dateformat: "required",
//     terms: "required"
//   },
//   messages: {
//     firstname: "Enter your firstname",
//     lastname: "Enter your lastname",
//     username: {
//       required: "Enter a username",
//       minlength: jQuery.validator.format("Enter at least {0} characters"),
//       remote: jQuery.validator.format("{0} is already in use")
//     },
//     password: {
//       required: "Provide a password",
//       minlength: jQuery.validator.format("Enter at least {0} characters")
//     },
//     password_confirm: {
//       required: "Repeat your password",
//       minlength: jQuery.validator.format("Enter at least {0} characters"),
//       equalTo: "Enter the same password as above"
//     },
//     email: {
//       required: "Please enter a valid email address",
//       minlength: "Please enter a valid email address",
//       remote: jQuery.validator.format("{0} is already in use")
//     },
//     dateformat: "Choose your preferred dateformat",
//     terms: " "
//   },
//   // the errorPlacement has to take the table layout into account
//   errorPlacement: function(error, element) {
//     if (element.is(":radio"))
//       error.appendTo(element.parent().next().next());
//     else if (element.is(":checkbox"))
//       error.appendTo(element.next());
//     else
//       error.appendTo(element.parent().next());
//   },
//   // specifying a submitHandler prevents the default submit, good for the demo
//   submitHandler: function() {
//     alert("submitted!");
//   },
//   // set this class to error-labels to indicate valid fields
//   success: function(label) {
//     // set &nbsp; as text for IE
//     label.html("&nbsp;").addClass("checked");
//   },
//   highlight: function(element, errorClass) {
//     $(element).parent().next().find("." + errorClass).removeClass("checked");
//   }
// });


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
