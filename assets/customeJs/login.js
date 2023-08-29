$(document).ready(function() {  
    $("#loginForm").validate({
            rules: {   
                username: {
                    required : true,
                },
                password: {
                    required : true,
                    minlength : 6,
                },
            },        
            messages: {            
                username:{
                    required :"Please Enter The Username",
                },  
                password: {
                    required : "Please Enter Your Password",
                    minlength : "Password must be 6 Character"
                },
            }
        });   

    $('#loginForm').submit(function(){
        var formStatus = $("#loginForm").validate().form();
        if(true == formStatus)
        {
            var data = $('#loginForm').serialize();
                data += "&submit=1";
                $.ajax({                                      
                    type: 'POST',
                    url: 'login-check',
                    dataType: 'json',
                    data: data,             
                    success: function(response)
                    {    
                        if(response.status  == true)
                        {
                            window.location.href =  response.url;
                           

                        }else{
                            $.toast({
                                heading: 'Error',
                                text: response.error,
                                showHideTransition: 'fade',
                                icon: 'error'
                            })
                        }
                        return false;     
                    }                
                    
            });
            return false;
        } 
        });
});

