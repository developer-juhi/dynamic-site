<section id="home" class="main-banner parallaxie" style="background: url('assets/userAssets/uploads/banner-01.jpg')">
		<div class="heading">
			<h1>Welcome to OnNext</h1>			
			<h3 class="cd-headline clip is-full-width">
				<span>Lorem Ipsum Dolor Sit Amet </span>
				
			</h3>
		</div>
</section>

    <div id="about" class="section wb">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="message-box">                        
						<h2>Advocate Ankit Raval</h2>
						
                        <p> 
							<?php foreach($aboutusData as $aboutus){
								echo $aboutus['aboutus_title'];
							}
							?>
						</p>

                    </div><!-- end messagebox -->
                </div><!-- end col -->

                <div class="col-md-6">
                    <div class="right-box-pro wow fadeIn">
                        <img src="<?php echo base_url();?>assets/userAssets/uploads/about_04.jpg" alt="" class="img-fluid img-rounded">
                    </div><!-- end media -->
                </div><!-- end col -->
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end section -->
	
    <div id="services" class="section lb">
        <div class="container">
            <div class="section-title text-center">
                <h3>Services</h3>
            </div><!-- end title -->

            <div class="row">
				<?php foreach($serviceData as $service){?>
					<div class="col-md-4">
						<div class="services-inner-box">
							<div class="ser-icon">
								<img src="<?php echo base_url();?>assets/userAssets/uploads/gallery_img-01.jpg" class="img-fluid" alt="Image">
							</div>
							<h2><?php echo $service['service_title'];?> </h2>
							<p><?php echo $service['service_details'];?></p>
						</div>
					</div><!-- end col -->
				<?php } ?>
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end section -->
	
	<div id="portfolio" class="section lb">
		<div class="container">
			<div class="section-title text-center">
                <h3>Portfolio</h3>
            </div><!-- end title -->
			
		
			
			<div class="gallery-list row">
				<?php foreach($portfolioData as $portfolio){?>

					<div class="col-md-4 col-sm-6 gallery-grid gal_a gal_b">
						<div class="gallery-single fix">
							<img src="<?php echo base_url($portfolio['portfolio_image']);?>" class="img-fluid" alt="Image">
							<div class="img-overlay">
								<a href="uploads/gallery_img-01.jpg" data-rel="prettyPhoto[gal]" class="hoverbutton global-radius"><i class="fa fa-picture-o"></i></a>
							</div>
						</div>
					</div>
				<?php 	}?>			
			
			</div>
			</div>
		</div>
	</div>
	
	
	<div id="blog" class="section lb">
		<div class="container">
			<div class="section-title text-center">
                <h3>Blog</h3>
            </div><!-- end title -->
			
			<div class="row">
				<?php foreach($blogData as $blog){?>

					<div class="col-md-4 col-sm-6 col-lg-4">
						<div class="post-box">
							<div class="post-thumb">
								<img src="<?php echo base_url($blog['blog_image']);?>" class="img-fluid" alt="post-img" />
								
							</div>
							<div class="post-info">
								<h4><?php echo $blog['blog_title'];?>.</h4>
								
								<p><?php echo $blog['blog_details'];?></p>
							</div>
						</div>
					</div>
				<?php }?>
			</div>
			
		</div>
	</div>


    <div id="contact" class="section db">
        <div class="container">
            <div class="section-title text-center">
                <h3>Contact</h3>
                <p>Quisque eget nisl id nulla sagittis auctor quis id. Aliquam quis vehicula enim, non aliquam risus.</p>
            </div><!-- end title -->

            <div class="row">
                <div class="col-md-12">
                    <div class="contact_form">
                        <div id="message"></div>
                        <form id="contacus" name="contacus" >
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<input class="form-control" id="fullname" name="fullname" type="text" placeholder="Your Name" required="required" data-validation-required-message="Please enter your name.">
										<p class="help-block text-danger"></p>
									</div>
									<div class="form-group">
										<input class="form-control" id="email" name="email"type="email" placeholder="Your Email" required="required" data-validation-required-message="Please enter your email address.">
										<p class="help-block text-danger"></p>
									</div>
									<div class="form-group">
										<input class="form-control" id="mobileno" name="mobileno"type="tel" placeholder="Your Phone" required="required" data-validation-required-message="Please enter your phone number.">
										<p class="help-block text-danger"></p>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<textarea class="form-control" id="message" name="message"placeholder="Your Message" required="required" data-validation-required-message="Please enter a message."></textarea>
										<p class="help-block text-danger"></p>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="col-lg-12 text-center">
									<div id="success"></div>
									<button id="sendMessageButton" class="sim-btn hvr-bounce-to-top" type="submit">Send Message</button>
								</div>
							</div>
						</form>
                    </div>
                </div><!-- end col -->
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end section -->