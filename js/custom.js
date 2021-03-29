/**************************************
    File Name: custom.js
    Template Name: Tech Blog
    Created By: HTML.Design
    http://themeforest.net/user/wpdestek
**************************************/

var newsApiUrl = "https://eventregistry.org/api/v1/";
var newsApiKey = "44eea5af-7346-4545-869d-2d8faf9bd482";
var scrollPage = 1;
(function($) {
    "use strict";
    $(document).ready(function() {
		loadNews(1,'','',"news/Arts_and_Entertainment",'',1)
        $('#nav-expander').on('click', function(e) {
            e.preventDefault();
            $('body').toggleClass('nav-expanded');
        });
        $('#nav-close').on('click', function(e) {
            e.preventDefault();
            $('body').removeClass('nav-expanded');
        });
    });

    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })

    $('.carousel').carousel({
        interval: 4000
    })

    $(window).load(function() {
        $("#preloader").on(500).fadeOut();
        $(".preloader").on(600).fadeOut("slow");
    });

    // jQuery(window).scroll(function(){
    //     if (jQuery(this).scrollTop() > 1) {
    //         jQuery('.dmtop').css({bottom:"25px"});
    //     } else {
    //         jQuery('.dmtop').css({bottom:"-100px"});
    //     }
    // });
    // jQuery('.dmtop').click(function(){
    //     jQuery('html, body').animate({scrollTop: '0px'}, 800);
    //     return false;
    // });

    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() >= $(document).height() && $('.row_details').length >= 20){
            scrollPage++;
            var category = $("#category").attr('category_uri');
            var author = $("#author").attr('author_uri');
            var source = $("#source").attr('source_uri');
            var title = $("#title").val();
            if(category || author || source || title)
                loadNews(scrollPage,author,title,category,source,reload=0)
            else 
            loadNews(scrollPage,'','',"news/Arts_and_Entertainment",'',0)
        }
    });
})(jQuery);


function openCategory(evt, catName) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the link that opened the tab
    document.getElementById(catName).style.display = "block";
    evt.currentTarget.className += " active";
} 




function loadNews(page = 1,authorUri,title,categoryUri,providerUri,reload=0)
{
    $(".loader").css('display','block');
	var param = "articlesSortByAsc=true&keywordLoc=title&apiKey="+newsApiKey+"&articlesCount=20&articlesPage="+page;
    if(authorUri){
        param += "&authorUri="+authorUri;
    }
    if(categoryUri){
        param += "&categoryUri="+categoryUri;
    }
    if(providerUri){
        param += "&sourceUri="+providerUri;
    }
    if(title){
        param += "&keyword="+title;
    }
    
    var settings = {
        "url": newsApiUrl+"article/getArticles?"+param,
        "method": "GET",
        "timeout": 0,
        "headers": {
          "Content-Type": "application/json"
        },
    };
      
    $.ajax(settings).done(function (response) {
        var response = response.articles;
        if(response.count > 0){
            var html = '';
            $.each( response.results, function( key, value ) {
                html += `<div class="blog-box row row_details">
                            <div class="col-md-4">
                                <div class="post-media">
                                    <a href='detail.php?`+value.uri+`' title="">
                                        <img src=`+value.image+` alt="" class="img-fluid">
                                        <div class="hovereffect"></div>
                                    </a>
                                </div><!-- end media -->
                            </div><!-- end col -->

                            <div class="blog-meta big-meta col-md-8">
                                <h4><a href='detail.php?newsUri=`+value.uri+`' title="">`+value.title+`</a></h4>
                                <p class="news_body">`+value.body+`</p>
                                <small class="firstsmall"><a class="bg-orange" href="tech-category-01.html" title="">Gadgets</a></small>
                                <small><a href="tech-single.html" title="">`+value.date+`</a></small>
                            </div><!-- end meta -->
                </div><!-- end blog-box -->
                <hr class="invis">`;
            });
            if(reload) {
                $("#load_news").html(html);
            } else {
                $("#load_news").append(html);
            }
        } else {
            $("#load_news").html("No Record Found");
        }
         $(".loader").css('display','none');
    });
}

$( function() {
   
    $("#category").autocomplete({
        source: function (request, response) {
             $.ajax({
                 url: newsApiUrl+"suggestCategoriesFast?apiKey="+newsApiKey,
                 type: "GET",
                 data: request,
                 success: function (data) {
                     response($.map(data, function (el) {
                         return {
                             label: el.label,
                             value: el.uri
                         };
                     }));
                 }
             });
        },
        minLength: 2,
        select: function (event, ui) {
            this.value = ui.item.label;
            $(this).attr("category_uri",ui.item.value);
            event.preventDefault();
        }
    });

    $("#author").autocomplete({
        source: function (request, response) {
             $.ajax({
                 url: newsApiUrl+"suggestAuthorsFast?apiKey="+newsApiKey,
                 type: "GET",
                 data: request,
                 success: function (data) {
                     response($.map(data, function (el) {
                         return {
                             label: el.name,
                             value: el.uri
                         };
                     }));
                 }
             });
        },
        select: function (event, ui) {
            this.value = ui.item.label;
            $(this).attr("author_uri",ui.item.value);
            event.preventDefault();
        }
    });

    $("#source").autocomplete({
        source: function (request, response) {
             $.ajax({
                 url: newsApiUrl+"suggestSourcesFast?apiKey="+newsApiKey,
                 type: "GET",
                 data: request,
                 success: function (data) {
                     response($.map(data, function (el) {
                         return {
                             label: el.title,
                             value: el.uri
                         };
                     }));
                 }
             });
        },
        select: function (event, ui) {
            this.value = ui.item.label;
            $(this).attr("source_uri",ui.item.value);
            event.preventDefault();
        }
    });

    $("#btnLoadNews").click(function(){
        var category = $("#category").attr('category_uri');
        var author = $("#author").attr('author_uri');
        var source = $("#source").attr('source_uri');
        var title = $("#title").val();
        if(category || author || source || title)
            loadNews(page = 1,author,title,category,source,reload=1)
    })

    $('#category').keyup(function(e){
        if(e.keyCode == 8){
            $(this).removeAttr('category_uri');
        }
    });

    $('#author').keyup(function(e){
        if(e.keyCode == 8){
            $(this).removeAttr('author_uri');
        }
    });

    $('#source').keyup(function(e){
        if(e.keyCode == 8){
            $(this).removeAttr('source_uri');
        }
    });

    $('#btnReset').click(function(e){
        loadNews(1,'','',"news/Arts_and_Entertainment",'',1)
    });

    
});