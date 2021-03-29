<?php 
require('inc/header.php'); 
require('config.php');


if(isset($_POST['submitComment'])){
    
    $comment = $_POST['comment'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $news_id = $_POST['news_id'];
    $rating = $_POST['rate'];

    $sql = "INSERT INTO comments (comment, name, email,news_id,rating) VALUES ('$comment', '$name', '$email','$news_id','$rating')";
    mysqli_query($conn, $sql);
}


if(isset($_GET['newsUri']) && $_GET['newsUri']){
	
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://eventregistry.org/api/v1/article/getArticle?apiKey=44eea5af-7346-4545-869d-2d8faf9bd482&articleUri=6493727933&articleUri='.$_GET['newsUri'],
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'GET',
	));
	
	$response = curl_exec($curl);
	
	curl_close($curl);
	$result = json_decode($response,true);
    $article = $result[$_GET['newsUri']];
    $article = $article['info'];

    $news_id = $_GET['newsUri'];
    $prj= mysqli_query($conn,"select * from comments where news_id = $news_id order by id desc") or die(mysqli_error($conn));
    $newsArray = array();
    while($row = mysqli_fetch_assoc($prj)){
        $newsArray[] = $row;
    }

    $prj= mysqli_query($conn,"select sum(rating) from comments where news_id = $news_id") or die(mysqli_error($conn));
    $row = mysqli_fetch_row($prj);
    $rating = 0;
    if(!empty($row)){
        $rating = $row[0] / count($newsArray);
        $rating = round($rating);
    }
	
} else {
	header("Location: index.php");
	die();
	
}

$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";



?>

<div id="wrapper">
	<?php require('inc/nav.php'); ?>
	
	<section class="section single-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                        <div class="page-wrapper">
                            <div class="blog-title-area text-center">
                                <ol class="breadcrumb hidden-xs-down">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active"><?= $article['title']?></li>
                                </ol>

                                <h3><?= $article['title']?></h3>
                                <div class="row" style="display: block;">
                                    <div class="ratingdiv" style="width: 60px;display: block;position: relative;height: 12px;">
                                        <span class="fa fa-star <?= $rating > 1 ? 'checkedrating' : "uncheckedrating"?> checkedlabel"></span>
                                        <span class="fa fa-star <?= $rating > 2 ? 'checkedrating' : "uncheckedrating"?> checkedlabel"></span>
                                        <span class="fa fa-star <?= $rating > 3 ? 'checkedrating' : "uncheckedrating"?> checkedlabel"></span>
                                        <span class="fa fa-star <?= $rating > 4 ? 'checkedrating' : "uncheckedrating"?> checkedlabel"></span>
                                        <span class="fa fa-star <?= $rating >= 5 ? 'checkedrating' : "uncheckedrating"?> checkedlabel"></span>
                                    </div>
                                    
                                    <div class="blog-meta big-meta" style="margin: auto;width: 102px;display: block;position: relative;margin-top: 5px;;">
                                        <small><a href="" title=""><?= date("dd M Y",strtotime($article['date']))?></a></small>
                                    </div><!-- end meta -->
                                </div>
                                <div class="post-sharing">
                                    <ul class="list-inline">
                                        <li><div class="fb-share-button" data-href="<?= $actual_link ?>" data-layout="button_count" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?= $actual_link?>&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div>
                                        </li>
                                        <li>
                                            <div class="whatsapp"><a href="https://api.whatsapp.com/send?text=<?= $actual_link?>" data-action="share/whatsapp/share" style="padding: 4px 10px;color: #fff;background: #55ba40;border-radius: 5px;"><i class="fa fa-whatsapp"></i>Share</a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="whatsapp">
                                                <a class="twitter-share-button" style="padding: 4px 10px;color: #fff;background: #019fde;border-radius: 5px;"
                                                  href="https://twitter.com/share?url=<?= $actual_link?>"
                                                  data-size="large" data-count="horizontal"><i class="fa fa-twitter"></i>
                                                Tweet</a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="whatsapp">
                                                <a style="display:block;font-size:16px;font-weight:500;text-align:center;border-radius:5px;padding:1px 5px;background:#389ce9;text-decoration:none;color:#fff;" href="https://xn--r1a.link/share/url?url=<?= $actual_link?>" target="_blank"><svg style="width:30px;height:20px;vertical-align:middle;margin:0px 5px;" viewBox="0 0 21 18"><g fill="none"><path fill="#ffffff" d="M0.554,7.092 L19.117,0.078 C19.737,-0.156 20.429,0.156 20.663,0.776 C20.745,0.994 20.763,1.23 20.713,1.457 L17.513,16.059 C17.351,16.799 16.62,17.268 15.88,17.105 C15.696,17.065 15.523,16.987 15.37,16.877 L8.997,12.271 C8.614,11.994 8.527,11.458 8.805,11.074 C8.835,11.033 8.869,10.994 8.905,10.958 L15.458,4.661 C15.594,4.53 15.598,4.313 15.467,4.176 C15.354,4.059 15.174,4.037 15.036,4.125 L6.104,9.795 C5.575,10.131 4.922,10.207 4.329,10.002 L0.577,8.704 C0.13,8.55 -0.107,8.061 0.047,7.614 C0.131,7.374 0.316,7.182 0.554,7.092 Z"></path></g></svg>Telegram</a>
                                                
                                            </div>
                                        </li>
                                    </ul>
                                </div><!-- end post-sharing -->
                            </div><!-- end title -->

                            <div class="single-post-media">
                                <img src="<?= $article['image']?>" alt="" class="img-fluid">
                            </div><!-- end media -->

                            <div class="blog-content">  
                                <div class="pp">
                                    <p><?= $article['body']?></p>

                                </div><!-- end pp -->
                            </div><!-- end content -->

                            <hr class="invis1">

                            <div class="custombox clearfix">
                                <h4 class="small-title"><?= count($newsArray)?> Comments</h4>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="comments-list">
                                            <?php foreach($newsArray as $news){?>
                                                <div class="media last-child">
                                                    <div class="media-body">
                                                        <h4 class="media-heading user_name"><?php echo $news['name']?> <small><?= date("d M Y",strtotime($news['created_at']))?></small></h4>
                                                        <div class="">
                                                            <span class="fa fa-star <?= $news['rating'] > 1 ? 'checkedrating' : "uncheckedrating"?> checkedlabel"></span>
                                                            <span class="fa fa-star <?= $news['rating'] > 2 ? 'checkedrating' : "uncheckedrating"?> checkedlabel"></span>
                                                            <span class="fa fa-star <?= $news['rating'] > 3 ? 'checkedrating' : "uncheckedrating"?> checkedlabel"></span>
                                                            <span class="fa fa-star <?= $news['rating'] > 4 ? 'checkedrating' : "uncheckedrating"?> checkedlabel"></span>
                                                            <span class="fa fa-star <?= $news['rating'] >= 5 ? 'checkedrating' : "uncheckedrating"?> checkedlabel"></span>
                                                        </div>
                                                        <div style='float:left;width:100%'><?php echo $news['comment']?></div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div><!-- end col -->
                                </div><!-- end row -->
                            </div><!-- end custom-box -->

                            <hr class="invis1">

                            <div class="custombox clearfix">
                                <h4 class="small-title">Leave a Reply</h4>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form class="form-wrapper" method="POST">
                                            <div class="rate">
                                                <input type="radio" id="star5" name="rate" value="5" />
                                                <label for="star5" title="text">5 stars</label>
                                                <input type="radio" id="star4" name="rate" value="4" />
                                                <label for="star4" title="text">4 stars</label>
                                                <input type="radio" id="star3" name="rate" value="3" />
                                                <label for="star3" title="text">3 stars</label>
                                                <input type="radio" id="star2" name="rate" value="2" />
                                                <label for="star2" title="text">2 stars</label>
                                                <input type="radio" id="star1" name="rate" value="1" />
                                                <label for="star1" title="text">1 star</label>
                                            </div>

                                            <input type="hidden" class="form-control" name="news_id" id="news_id" value="<?= $_GET['newsUri'] ?>">
                                            <input type="text" class="form-control" name="name" required id="name" placeholder="Your name">
                                            <input type="text" class="form-control" name="email" required id="email" placeholder="Email address">
                                            <textarea class="form-control" placeholder="Your comment" required name="comment" id="comment"></textarea>
                                            <button type="submit" class="btn btn-primary" name="submitComment">Submit Comment</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end page-wrapper -->
                    </div><!-- end col -->

                </div><!-- end row -->
            </div><!-- end container -->
        </section>
	<?php require('inc/footer_nav.php'); ?>
</div>
	
<?php require('inc/footer.php'); ?>