$(window).ready(function () {
    "use strict";
    $('.basic').selectric();

    $('.popuplink').fancybox({
        padding: 10,
        maxWidth: 800,
        maxHeight: 330,
        fitToView: false,
        autoSize: true,
        width: '100%',
        height: '80%',
        openEffect: 'fade',
        closeEffect: 'fade'
    });


    /*$('.home-link').click(function () {
     $.fancybox({
     'type': 'inline',
     'href': '#loginPopup'
     });
     
     
     });*/
    /*$('.gallery a').fancybox({
     padding:0,
     fitToView	: true,
     autoSize	: true,
     openEffect	: 'fade',
     closeEffect	: 'fade'
     });*/
    /*var evt;
     var elements;
     $('.filter-box').click(function () {
     evt = this;
     $(".sublinks").empty();		
     elements = $(evt).find('.sub-link-main').clone();
     if($(evt).find('div').hasClass( "sub-link-main" )){
     $.fancybox([
     { href : '#sublinks',padding:0,content:elements}			
     ]);
     }		
     else{
     
     }
     });*/
    $('.filter-link').click(function () {
        $('.filter-main').slideToggle();
        if ($('.filter-scroll ul').height() > total_height) {
            $('.filter-scroll').css({'height': total_height});
        }
    });
    $('.forgot-pass').click(function () {
        $('.forgotpass-main').slideToggle();
    });

    $('.main-user').click(function () {
        $('.subuser').slideToggle();
    });
    $('.slidmenu').click(function () {
        $('.main,.menu-wrapper,.bottom-holder,header,.meet-invite').toggleClass('active');
        $('header,.bottom-holder,.meet-invite').toggleClass('overflow-hide');
        $('.subuser').slideUp();
    });
    $('.close-menu').click(function () {
        $('.main,.menu-wrapper,.bottom-holder,header,.meet-invite').removeClass('active');
        $('.subuser').slideUp();
        setTimeout(function () {
            $('header,.bottom-holder,.meet-invite').removeClass('overflow-hide');
        }, 500);
    });
    $('.editHourDayBtn').click(function () {
        $('.threebtns').hide();
        $('.twobtns').show();

        $('.budgetVal,.dayVal').show();

        $('.budgetVal input').val($('.amountText').text());
        $('.dayVal input').val($('.dayText').text());

        $('.amountText,.dayText').hide();
        $('.typeAmt,.daysAmt').addClass('grey-bg');
    });
    $('.sendTimingBtn').click(function () {
        $('.amountText,.dayText').show();
        $('.typeAmt,.daysAmt').removeClass('grey-bg');
        $('.amountText').text($('.budgetVal input').val());
        $('.dayText').text($('.dayVal input').val());
        $('.budgetVal,.dayVal').hide();

        $('.twobtns').hide();
        $('.threebtns').show();
    });
    //var amountText = $('.amountText').text();
    //var dayText = $('.dayText').text();
    $('.cancelEditBtn').click(function () {
        $('.amountText,.dayText').show();
        $('.typeAmt,.daysAmt').removeClass('grey-bg');
        $('.amountText').text($('.budgetVal input').val());
        $('.dayText').text($('.dayVal input').val());
        $('.budgetVal,.dayVal').hide();

        $('.twobtns').hide();
        $('.threebtns').show();
    });

    
    $('.filter-box').click(function () {
        $('.photo-job-video').toggleClass('opened');
        $('.filter-link').text($(this).find('.fltr-title').text());
    });

    var msg_id;
    $('.msgdtl').click(function () {
        msg_id = $(this).attr('role');
        $('#' + msg_id + ',header,.main,.bottom-holder').addClass('active');
    });
    $('.arrow-left').click(function () {
        $('#' + msg_id + ',header,.main,.bottom-holder').removeClass('active');
    });
    $('.feedback-div').click(function () {
        $(this).next('.feedTextarea').slideToggle();
    });

    $(document).mouseup(function (e)
    {
        var container1 = $('.filter-main');
        var container2 = $('.filter-link');
        var container22 = $('.fancybox-slider-wrap');
        if (!container1.is(e.target) && container1.has(e.target).length === 0)
        {
            if (!container2.is(e.target) && container2.has(e.target).length === 0)
            {
                if (!container22.is(e.target) && container22.has(e.target).length === 0)
                {
                    container1.slideUp();
                }
            }
        }
        var container3 = $('.photo-job-video');
        var container4 = $('.plus-link');
        if (!container1.is(e.target) && container3.has(e.target).length === 0)
        {
            if (!container4.is(e.target) && container4.has(e.target).length === 0)
            {
                container3.removeClass('opened');
                container4.removeClass('selected');
            }
        }
    });
    bowling_thumb();
    adjustWidthHeight();
});
var win_width;
var win_height;
var total_height;
var filter_height;
var header_height;
var bottom_height;
var triangle_height;
var resetButtonWidth;
function adjustWidthHeight() {
    "use strict";
    win_width = $(window).width();
    win_height = $(window).height();
    header_height = $('header .container').innerHeight();
    bottom_height = $('.work-hire-main').innerHeight();
    //triangle_height = $('.triangle-div').innerHeight();
    //resetbutton = $('.reset-button').innerHeight();
    triangle_height = 12;
    if (win_width < 576) {
        if (win_width > 413) {
            resetButtonWidth = 50;
        } else {
            if (win_width > 374) {
                resetButtonWidth = 45;
            } else {
                if (win_width > 300) {
                    resetButtonWidth = 32;
                }
            }
        }
    } else {
        resetButtonWidth = 62;
    }

    filter_height = header_height + bottom_height + triangle_height;
    total_height = win_height - filter_height;
    total_height = total_height - 15;
    if ($('.filter-scroll ul').height() > total_height) {
        $('.filter-scroll').css({'height': total_height});
    }


    //$('.filter-main').css({'width':win_width});
    //$('.filter-main').css({'height':total_height});
    $('header').css({'height': $('header .container').height()});

    $('.menu-main-sub').css({'height': $('.menu-wrapper').height()});

    var messages_header = $('.messages-header').innerHeight();
    //alert(win_height);
    messages_header = win_height - messages_header;
    $('.messages-detail-main .notification').css({'height': messages_header});
    $('.main').css({'min-height': win_height});
    //filterbox();
    var wrapper_width = $('.wrapper').width();
    $('.menu-wrapper-sub').css({'width': wrapper_width});


}

/*function filterbox(){
 "use strict";
 var width_filtr = $('.filter-sub ul li').width();
 var height_filtr = width_filtr/1.5;
 $('.filter-box').css({'width':width_filtr});
 $('.filter-box').css({'height':height_filtr});
 
 
 }*/



/*$(window).load(function() {
 "use strict";	
 adjustWidthHeight();
 //$('.alertPopupLink').trigger('click');
 //$('.loginPopupLink').trigger('click');
 });*/

/*var owl_item_img;
 var owl_item_ht;
 var owl_item;
 var owl_item_ml;
 function bowling_thumb(){
 "use strict";
 $(".setSize").each(function (){
 if($(this).find('.photograph')){
 $(this).removeClass('set-width');
 $(this).removeClass('set-height');
 owl_item_img = $(this).width();
 owl_item_ht = $(this).height();
 $(this).find('.photograph').css({'height':owl_item_ht+'px'});
 owl_item = $(this).find('.photograph').width();
 if(owl_item_img > owl_item){
 }
 else{
 }
 if(owl_item_img < owl_item){
 owl_item_ml = owl_item - owl_item_img;
 $(this).find('.photograph img').css({'margin-left':-(owl_item_ml/2)+'px'});
 $(this).find('.photograph').css({'width':owl_item+'px'});
 $(this).addClass('set-height');
 
 }
 else{
 $(this).find('.photograph img').css({'margin-left':0+'px'});
 $(this).find('.photograph').css({'width':owl_item_img+'px'});
 $(this).addClass('set-width');
 
 }
 }
 });
 }*/
var photo_width;
var photo_height;
var this_width;
var this_height;
var photo_new_width;
var photo_new_height;
var photo_ml;
function bowling_thumb() {
    "use strict";
    $(".setSize").each(function () {
        if ($(this).find('.photograph')) {
            $(this).removeClass('set-width');
            $(this).removeClass('set-height');
            $(this).find('.photograph').removeAttr('style');
            this_width = $(this).width();
            this_height = $(this).height();
            photo_width = $(this).find('.photograph img').width();
            photo_height = $(this).find('.photograph img').height();
            console.log('width: ' + photo_width + '= height: ' + photo_height);
            if (photo_width > photo_height) {
                $(this).find('.photograph').css({'height': this_height});
                $(this).addClass('set-height');
                photo_new_width = $(this).find('.photograph').width();
                photo_new_height = $(this).find('.photograph').height();
                $(this).find('.photograph img').css({'height': this_height});
                //var photo_img =  $(this).find('.photograph img').width();
                photo_ml = photo_new_width - this_width;
                //console.log('width: '+photo_new_width+'= height: '+photo_new_height+'= tot: '+photo_ml+'= Photo: '+photo_img);				
                if (photo_ml > 1) {
                    $(this).find('.photograph').css({'margin-left': -(photo_ml / 2) + 'px'});
                } else {
                    $(this).find('.photograph').css({'margin-left': (photo_ml / 2) + 'px'});
                }

            } else {
                $(this).find('.photograph').css({'width': this_width});
                $(this).find('.photograph').css({'height': this_height});
                $(this).find('.photograph img').css({'min-height': this_height});
                $(this).addClass('set-width');
            }
        }
    });
}
$(window).load(function () {
    "use strict";
    bowling_thumb();
});
$(window).resize(function () {
    "use strict";
    adjustWidthHeight();
    bowling_thumb();
});

//Retina Graphics 
function highdpi_init() {
    "use strict";
    $(".replace-2x").each(function () {
        if ($(this).css("font-size") == "1px") {
            var src = $(this).attr("src");
            $(this).attr("src", src.replace(/(@2x)*.png/i, "@2x.png").replace(/(@2x)*.jpg/i, "@2x.jpg"));
        }
    });
}
jQuery(document).ready(function () {
    "use strict";
    highdpi_init();
    //bowling_thumb();
});

/*function heightOfBoxes(){
 "use strict";	 
 var max = -1;
 var h;
 $('.category-contents').find('.category-div').each(function() {
 $('.category-contents .category-div').css({'height':'auto'});
 h = $(this).innerHeight();
 max = h > max ? h : max;
 $('.category-contents .category-div').css({'height':max});
 });	 
 }
 */