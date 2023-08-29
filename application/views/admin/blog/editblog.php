<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-3"></div>
                <div class="col-6 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Edit Blog</h4>                    
                            <form name="editBlogForm" id="editBlogForm" method="post" enctype="multipart/form-data"> 
                                <input class="form-control" type="hidden" id="blogid" name="blogid" value="<?php echo $blogData['blog_id']; ?>">

                                <div class="form-group">
                                    <label for="example-text-input" class="col-form-label">Blog Name</label>
                                    <input class="form-control" type="text" id="editBlogName" name="editBlogName" value="<?php echo $blogData['blog_title']; ?>" placeholder="blog Name">
                                </div>

                                <div class="form-group">
                                    <label for="example-text-input" class="col-form-label">Blog Details</label>
                                    <textarea class="form-control" id="editBlogDetail" name="editBlogDetail" aria-label="With textarea" placeholder="blog Details"><?php echo $blogData['blog_details']; ?></textarea>
                                </div>

                                <div class="form-group">
                                    <span>blog Image :</span>
                                    <input type="file" class="form-control" id="editblogImg" name="editblogImg"  accept="image/*" onchange="loadFile(event)">
                                    <img id="output" src="<?php echo base_url($blogData['blog_image']); ?>" class="m20" style="background: #0c0c0c;height: 115px;"/>
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