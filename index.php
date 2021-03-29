<?php require('inc/header.php'); ?>

<div id="wrapper">
    <div class="loader"></div>
	<?php require('inc/nav.php'); ?>
	
        <section class="section first-section" style="margin-top:7rem;">
			<div class="container">
                <div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<form role="form" class="inline" method="post" action="">
								<div class="row"> 
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
										<label class="col-xs-10 col-sm-2 col-md-1 control-label" for="filters">Category:</label>
										<input type="text" class="form-control" name="category" id="category" />
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
										<label class="col-xs-10 col-sm-2 col-md-1 control-label" for="filters">Author:</label>
										<input type="text" class="form-control" name="author" id="author" />
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
										<label class="col-xs-10 col-sm-2 col-md-1 control-label" for="filters">Provider:</label>
										<input type="text" class="form-control" name="source" id="source" />
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<label class="col-xs-10 col-sm-2 col-md-1 control-label" for="filters">Title:</label>
										<input type="text" class="form-control" name="title" id="title" />
									</div>
									<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
										<label class="col-xs-10 col-sm-2 col-md-1 control-label" for="filters"></label>
										<input type="button" value="Search News" name="submit" class="submit btn btn-success" id="btnLoadNews"/>
									</div>
									<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
										<label class="col-xs-10 col-sm-2 col-md-1 control-label" for="filters"></label>
										<input type="button" value="Reset Filters" name="reset" class="btn btn-warning" id="btnReset"/>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
            </div>
        </section>

        <section class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="page-wrapper">
                            <div class="blog-top clearfix">
                                <h4 class="pull-left">Recent News <a href="#"><i class="fa fa-rss"></i></a></h4>
                            </div><!-- end blog-top -->

                            <div class="blog-list clearfix" id="load_news">
                                

                            </div><!-- end blog-list -->
                        </div><!-- end page-wrapper -->

                        <hr class="invis">
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end container -->
        </section>

	<?php require('inc/footer_nav.php'); ?>
</div>
	
<?php require('inc/footer.php'); ?>