"use strict";

$(document).ready(function(){
    ////////////////////
    //header processing/
    ////////////////////
    //stick header to top
    //wrap header with div for smooth sticking
    var $header = jQuery('.page_header').first();
    if ($header.length) {
      var headerHeight = $header.outerHeight();
      $header.wrap('<div class="page_header_wrapper"></div>').parent().css({height: headerHeight}); //wrap header for smooth stick and unstick

        //get offset
      var headerOffset = 0;
      //check for sticked template headers
      headerOffset = $header.offset().top;


      jQuery($header).affix({
        offset: {
          top: headerOffset,
          bottom: 0
        }
      });
        //if header has different height on afixed and affixed-top positions - correcting wrapper height
      jQuery($header).on('affixed-top.bs.affix', function () {
        $header.parent().css({height: $header.outerHeight()});
      });
    }

    // Contact form /
  var regVr22 = "<div><span style='font: 14px Arial; color:#fff; margin-left:6px;'>sending...</span></div><br />";
  $("#send").click(function(){
      $("#loadBar").html(regVr22).show();
      var posName = $("#posName").val();
          var posTel = $("#posTel").val();
      var posEmail = $("#posEmail").val();
      var posText = $("#posText").val();
      $.ajax({
        type: "POST",
        url: "contact.php",
        data: {"posName": posName, "posTel": posTel, "posEmail": posEmail, "posText": posText},
        cache: false,
        success: function(response){
      var messageResp = "<p style='font-family:Arial; font-size:14px; color:#fff; padding:10px; margin:0px; border-radius:5px; -moz-border-radius:5px; -webkit-border-radius:5px;'>Dear <strong>";
      var resultStat = "!</strong> Message sent!</p>";
      var oll = (messageResp + posName + resultStat);
          if(response == 1){
                  $("#loadBar").html(oll).fadeIn(3000);
          $("#posName").val("");
                  $("#posTel").val("");
          $("#posEmail").val("");
          $("#posText").val("");
          } else {
      $("#loadBar").html(response).fadeIn(3000); }
                      }
      });
      return false;
  });
 
  /*Slider*/      
  $("#owl-demo").owlCarousel({
      items : 1,
      autoPlay: 3500,
      navigation : false, // Show next and prev buttons
      slideSpeed : 700,
      pagination : true,
      paginationSpeed : 900,
      singleItem:true
  });   
  $(".owl-testimonials").owlCarousel({
 
      autoPlay: 3000, //Set AutoPlay to 3 seconds
 
      items : 3,
      itemsDesktop : [1199,3],
      itemsDesktopSmall : [979,3]
 
  });
  $(".owl-blog").owlCarousel({
      items : 1,
      autoPlay: 3500,
      navigation : false, // Show next and prev buttons
      slideSpeed : 700,
      pagination : true,
      paginationSpeed : 900,
      singleItem:true
   }); 
   //mailchimp subscribe form processing
    jQuery('.signup').on('submit', function( e ) {
        e.preventDefault();
        var $form = jQuery(this);
        // update user interface
        $form.find('.response').html('Adding email address...');
        // Prepare query string and send AJAX request
        jQuery.ajax({
            url: 'mailchimp/store-address.php',
            data: 'ajax=true&email=' + escape($form.find('.mailchimp_email').val()),
            success: function(msg) {
                $form.find('.response').html(msg);
            }
        });
    });
    
    /*Nav*/
    $(".flexnav").flexNav();  


});

jQuery(window).resize(function(){

  //header processing
  var $header = jQuery('.page_header').first();
    //checking document scrolling position
  if ($header.length && !jQuery(document).scrollTop() && $header.first().data('bs.affix')) {
    $header.first().data('bs.affix').options.offset.top = $header.offset().top;
  }
  jQuery(".page_header_wrapper").css({height: $header.first().outerHeight()}); //editing header wrapper height for smooth stick and unstick
 
});

jQuery(window).load(function(){
  //flickr
  // use http://idgettr.com/ to find your ID
  if (jQuery().jflickrfeed) {
    jQuery("#flickr").jflickrfeed({
      flickrbase: "http://api.flickr.com/services/feeds/",
      limit: 8,
      qstrings: {
        id: "142259483@N08"
      },
      itemTemplate: '<a href="{{image_b}}" data-gal="prettyPhoto[pp_gal]"><li><img alt="{{title}}" src="{{image_s}}" /></li></a>'
    }, function(data) {

    });
  }
});