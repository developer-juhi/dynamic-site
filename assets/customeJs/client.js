$(document).ready(function() {  
    $('#client_list').DataTable({  
        "processing": true,
        "serverSide": true, 
        "order": [], 
    
        "ajax": {
            "url": "admin-client-fetch",
            "dataType": "json",
            "type": "POST",
        }, 
        "columnDefs": [
            { 
                "targets": [0,1,2], 
                "orderable": false, 
            },
        ],
        "columns": [
            { "width": "20%" },
            { "width": "60%" },
            { "width": "20%" },
               
        ]
        
    });
    
    // validation
    $("#addClientForm").validate({
            rules: {               
                clientImg: {
                    required : true,
                },            
            },        
            messages: {            
         
                clientImg:{
                    required :"Enter the client image",
                },  
            }
        });   
    $('#addClientForm').submit(function(){
        var formStatus = $("#addClientForm").validate().form();
        if(true == formStatus)
        {
            var data = new FormData(document.getElementById("addClientForm"));
            $.ajax({                                      
                type: 'POST',
                url: 'admin-client-register-save',
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
                            icon: 'error',
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

    $('#client_list').on('click', '.delete', function(){  

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
                    url:'admin-client-delete',
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
    

    $('#editClientForm').submit(function(){        
            var data = new FormData(document.getElementById("editClientForm"));
            $.ajax({                                      
                type: 'POST',
                url: 'client-update-save',
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
