<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-3"></div>
                <div class="col-6 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Edit Client</h4>                    
                            <form name="editClientForm" id="editClientForm" method="post" enctype="multipart/form-data"> 
                            <input type="hidden"  id="newid" name="" value="<?php echo $editClientData['client_id']; ?>" >

                              
                                <div class="form-group">
                                    <span>Client Image </span>
                                    <input type="file" class="form-control" id="editClientImg" name="editClientImg"  accept="image/*" onchange="loadFile(event)">
                                    <img id="output" src="<?php echo base_url($editClientData['client_img']); ?>" class="m20" style="background: #0c0c0c;height: 115px;"/>
                                </div>


                                <input type="submit" name="submit"  id="submit"  class="btn btn-primary mt-4 pl-4 pr-4">
                            </form>
                        </div>
                    </div>
                </div>
            <div class="col-3"></div>

        </div>
    </div>    
</div>
<script>

var loadFile = function(event) {
        var reader = new FileReader();
        reader.onload = function(){
          var output = document.getElementById('output');
          output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    };    
</script>