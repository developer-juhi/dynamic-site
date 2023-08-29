<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-3"></div>
                <div class="col-6 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Service Add </h4>                    
                            <form name="addSeviceForm" id="addSeviceForm"  method="post" enctype="multipart/form-data"> 

                                <div class="form-group">
                                    <label for="example-text-input" class="col-form-label">Service Name</label>
                                    <input class="form-control" type="text" id="serviceName" name="serviceName" placeholder="Service Name">
                                </div>

                                <div class="form-group">
                                    <label for="example-text-input" class="col-form-label">Service Details</label>
                                    <textarea class="form-control" id="serviceDetail" name="serviceDetail" aria-label="With textarea" placeholder="Service Details"></textarea>
                                </div>

                                <div class="form-group">
                                <label for="example-text-input" class="col-form-label">Service Image</label>

                                    <input type="file" class="form-control" id="serviceImg" name="serviceImg"  accept="image/*" onchange="loadFile(event);">
                                    <img id="output" class="m20" style="background: #0c0c0c;height: 115px;"/>
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