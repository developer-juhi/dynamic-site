$(document).ready(function() {  
    $('#aboutus_list').DataTable({  
        "processing": true,
        "serverSide": true, 
        "order": [], 
   
        "ajax": {
            "url": "admin-aboutus-fetch",
            "dataType": "json",
            "type": "POST",
        }, 
        "columnDefs": [
            { 
                "targets": [0,2], 
                "orderable": false, 
            },
        ],
        "columns": [
            { "width": "10%" },
            { "width": "60%" },
            { "width": "30%" },
     
          ]
      
    });

    // validation
    $("#aboutusForm").validate({
            rules: {   
                aboutustitle: {
                    required : true,
                },
            
            },        
            messages: {            
                aboutustitle:{
                    required :"Please About Us Title",
                },  

            }
        });   
    $('#aboutusForm').submit(function(){
        var formStatus = $("#aboutusForm").validate().form();
        if(true == formStatus)
        {
            var data = new FormData(document.getElementById("aboutusForm"));
            $.ajax({                                      
                type: 'POST',
                url: 'admin-aboutus-register-save',
                dataType: 'json',
                data: data,
                async: true,
                processData: false,
                contentType: false,            
                success: function(response)
                {                      
                   if(response.status  == true)
                    {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 3000,                           
                          }); 
                          window.setTimeout(function(){ 
                            window.location.href =  response.url;

                        } ,3000); 
                                                                
                    }else{
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: response.error,
                            showConfirmButton: false,
                            timer: 3000,                           
                          });
                    
                        return false;     
                    }
                    return false;      
                } 
            });  
            return false;      
        }
    });

    $('#aboutus_list').on('click', '.delete', function(){  

        var id = $(this).attr("id");
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.value) {
                $.ajax({
                    url:'admin-aboutus-delete',
                    type: "POST",
                    dataType: 'json',
                    data: {
                        id:id
                    },
                    success: function(response)
                    {   
                        if(response.status  == true)
                        {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 3000,                           
                              }); 
                              window.setTimeout(function(){ 
                                location.reload();
                            } ,3000);      
                        }
                        else
                        {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: response.error,
                                showConfirmButton: false,
                                timer: 3000,                           
                              }); 
                        }
                        return false;       
                    }  
                });   
           
            }
          }) 

    });  
    

    $('#editAboutUsForm').submit(function(){
       
            var data = new FormData(document.getElementById("editAboutUsForm"));
            $.ajax({                                      
                type: 'POST',
                url: 'aboutus-updated-save',
                dataType: 'json',
                data: data,
                async: true,
                processData: false,
                contentType: false,            
                success: function(response)
                {                      
                   if(response.status  == true)
                    {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 3000,                           
                          }); 
                          window.setTimeout(function(){ 
                            window.location.href =  response.url;

                        } ,3000); 
                                                                
                    }else{
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: response.error,
                            showConfirmButton: false,
                            timer: 3000,                           
                          });
                    
                        return false;     
                    }
                    return false;      
                } 
            });  
            return false;      
    
    });

   
});