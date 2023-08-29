<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-3"></div>
                <div class="col-6 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Edit Service</h4>                    
                            <form name="editSeviceForm" id="editSeviceForm" method="post" enctype="multipart/form-data"> 
                                <input class="form-control" type="hidden" id="serviceid" name="serviceid" value="<?php echo $serviceData['service_id']; ?>">

                                <div class="form-group">
                                    <label for="example-text-input" class="col-form-label">service Name</label>
                                    <input class="form-control" type="text" id="editServiceName" name="editServiceName" value="<?php echo $serviceData['service_title']; ?>" placeholder="service Name">
                                </div>

                                <div class="form-group">
                                    <label for="example-text-input" class="col-form-label">service Details</label>
                                    <textarea class="form-control" id="editServiceDetail" name="editServiceDetail" aria-label="With textarea" placeholder="service Details"><?php echo $serviceData['service_details']; ?></textarea>
                                </div>

                                <div class="form-group">
                                    <span>service Image :</span>
                                    <input type="file" class="form-control" id="editserviceImg" name="editserviceImg"  accept="image/*" onchange="loadFile(event)">
                                    <img id="output" src="<?php echo base_url($serviceData['service_image']); ?>" class="m20" style="background: #0c0c0c;height: 115px;"/>
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