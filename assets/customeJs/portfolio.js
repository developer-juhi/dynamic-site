$(document).ready(function() {  
    $('#portfolio_list').DataTable({  
        "processing": true,
        "serverSide": true, 
        "order": [], 
    
        "ajax": {
            "url": "admin-portfolio-fetch",
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
    $("#addPortfolioForm").validate({
            rules: {   
                portfolioName: {
                    required : true,
                },
                portfolioDetail: {
                    required : true,
                },
                portfolioImg: {
                    required : true,
                },
            
            },        
            messages: {            
                aboutustitle:{
                    required :"Enter the portfolio name",
                },  
                portfolioDetail:{
                    required :"Enter the portfolio details",
                },  
                portfolioImg:{
                    required :"Enter the portfolio image",
                },  

            }
        });   
    $('#addPortfolioForm').submit(function(){
        var formStatus = $("#addPortfolioForm").validate().form();
        if(true == formStatus)
        {
            var data = new FormData(document.getElementById("addPortfolioForm"));
            $.ajax({                                      
                type: 'POST',
                url: 'admin-portfolio-register-save',
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

    $('#portfolio_list').on('click', '.delete', function(){  

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
                    url:'admin-portfolio-delete',
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
    

    $('#editPortfolioForm').submit(function(){
        
            var data = new FormData(document.getElementById("editPortfolioForm"));
            $.ajax({                                      
                type: 'POST',
                url: 'portfolio-update-save',
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
