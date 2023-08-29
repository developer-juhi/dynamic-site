$(document).ready(function () {
  $("#contacus").validate({
      rules: {
          fullname: "required",
          mobileno: "required",
          email: "required",
          message: "required",
      },
      messages: {
          fullname: "Please Enter The  Name",
          mobileno: "Please Enter The  Mobile Number",
          email: "Please Enter The  Email",
          message: "Please Enter The  Message",
      }
  });
  $('#contacus').submit(function () {
      var formStatus = $("#contacus").validate().form();
      if (true == formStatus) {
          var data = $('#contacus').serialize();
          data += "&submit=1";
          $.ajax({
              type: 'POST',
              url: 'contact-us-save',
              dataType: 'json',
              data: data,
              success: function (response) {
                  if (response.status == true) {
                    

                  }
                  else {

                  
                  }
                  return false;
              }
          });
      }
      else {
         
      }
      return false;
  });
});

function isNumber(evt) {
  evt = (evt) ? evt : window.event;
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
  }
  return true;
}