$(document).ready(function() {  
    $('#blog_list').DataTable({  
        "processing": true,
        "serverSide": true, 
        "order": [], 
    
        "ajax": {
            "url": "admin-blog-fetch",
            "dataType": "json",
            "type": "POST",
        }, 
        "columnDefs": [
            { 
                "targets": [0,3,4], 
                "orderable": false, 
            },
        ],
        "columns": [
            { "width": "10%" },
            { "width": "10%" },
            { "width": "50%" },
            { "width": "10%" },
            { "width": "20%" },        
        ]
        
    });
    
    // validation
    $("#addBlogForm").validate({
            rules: {   
                blogName: {
                    required : true,
                },
                blogDetail: {
                    required : true,
                },
                blogImg: {
                    required : true,
                },
            
            },        
            messages: {            
                aboutustitle:{
                    required :"Enter the blog name",
                },  
                blogDetail:{
                    required :"Enter the blog details",
                },  
                blogImg:{
                    required :"Enter the blog image",
                },  

            }
        });   
    $('#addBlogForm').submit(function(){
        var formStatus = $("#addBlogForm").validate().form();
        if(true == formStatus)
        {
            var data = new FormData(document.getElementById("addBlogForm"));
            $.ajax({                                      
                type: 'POST',
                url: 'admin-blog-register-save',
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

    $('#blog_list').on('click', '.delete', function(){  

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
                    url:'admin-blog-delete',
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
    

    $('#editBlogForm').submit(function(){
        
            var data = new FormData(document.getElementById("editBlogForm"));
            $.ajax({                                      
                type: 'POST',
                url: 'blog-update-save',
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
