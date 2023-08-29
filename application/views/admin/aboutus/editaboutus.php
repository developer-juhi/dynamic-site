<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
        <div class="col-6 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Edit AboutUs</h4>                    
                    <form name="editAboutUsForm" id="editAboutUsForm" method="post" enctype="multipart/form-data"> 
                    <input class="form-control" type="hidden" id="aboutusid" name="aboutusid" value="<?php echo $data['aboutus_id']; ?>">

                        <div class="form-group">
                            <label for="example-text-input" class="col-form-label">AboutUs Title</label>
                            <input class="form-control" type="text" value="<?php echo $data['aboutus_title']; ?>" id="editaboutustitle" name="editaboutustitle" placeholder="AboutUs Title">
                        </div>                    
                        <input type="submit" name="submit"  class="btn btn-primary mt-4 pl-4 pr-4">
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>    
</div>
