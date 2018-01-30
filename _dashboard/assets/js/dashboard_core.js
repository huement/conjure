/*!

 =========================================================
 * Paper Dashboard - v1.1.2
 =========================================================

 * Product Page: https://bitbucket.org/derekscott_mm/WP_Conjure
 * Copyright 2017 MyriadMobile (https://myriadmobile.com)
 * Licensed under MIT (https://bitbucket.org/derekscott_mm/WP_Conjure/overview)

 =========================================================

 */

/* Function to animate height: auto */
function autoHeightAnimate(element, time){
  	var curHeight = element.height(), // Get Default Height
        autoHeight = element.css('height', 'auto').height(); // Get Auto Height
    	  element.height(curHeight); // Reset to Default Height
    	  element.stop().animate({ height: autoHeight }, time); // Animate to Auto Height
}

function iframeTerminalSetup() {
  if(iframeSetup === false){
    iframeSetup=true;
    var iframeURL = $('iframe#terminal_frame').data("src");
    $('iframe#terminal_frame').attr('src', iframeURL);
  }
}

var iframeSetup = false;
var fixedTop = false;
var transparent = true;
var navbar_initialized = false;

$(document).ready(function(){
    window_width = $(window).width();

    // Init navigation toggle for small screens
    if(window_width <= 991){
        pd.initRightMenu();
    }

    $(".dashboard-list .collapse-item .nav-link").on("click",function(eve){
      //eve.preventDefault();
      $(".nav-item.linked-page.active").toggleClass("active_collapse");
      $(this).toggleClass("active_collapse");
    });

    $(".dashboard-list .linked-page .nav-link").on("click",function(eve){
      eve.preventDefault();
      var gotourl= $(this).attr("href");
      var baseURL = $("#base_url").text();
      window.location.href = baseURL + "/?" + gotourl;
    });


    var aNav = $("#act_nav").text();
    aNav += "-nav";
    var activeNav = "#" + aNav;
    var activeNavString = $(activeNav).children(".nav-item p").text();

    $(activeNav).addClass("active").parent("li").addClass("active");

    $.each($(".sub-menu .linked-page.active"),function(index){
      $(this).parent(".sub-menu").removeClass("hide").addClass("show");
      $(this).parent("ul").parent(".collapse-item").addClass("active_submenu");
      var makeActiveLink = $(this).parent("ul").attr("id");
      console.log(makeActiveLink);
      $(".nav-link[href=\"#"+makeActiveLink+"\"]").addClass("active");
    });

    $("#dynpagename").html("<span class='red'>" + activeNavString + "</span>");

    var newTitle = "Conjure | " + activeNavString;

    $(document).prop('title', newTitle);

    $('.nav-link.dropdown-toggle').on('click',function(e){
       var dropdown=$(e.target).closest('.nav-link.dropdown-toggle');
       dropdown.toggleClass('show');
    });

    if($(".sub-menu .linked-page.active").html() !== undefined){
      $(activeNav).removeClass("active").addClass("active_submenu").parent("li").addClass("active");
    }

    //setTimeout("iframeTerminalSetup()",1000);

    var iframeOpts = {autoResize:true, checkOrigin:false, interval:100, maxHeight:1000, minHeight:750, scrolling:true, bodyMargin:10};
    $('iframe#terminal_frame').iFrameResize(iframeOpts);

    var nav = $('#terminal_frame_box'),
        animateTime = 500,
        navLink = $('#terminal_toogle');
    navLink.click(function(){
      if(nav.height() === 0){
        autoHeightAnimate(nav, animateTime);
        $("#terminal_frame_box").addClass("bottomMargin");
        if(iframeSetup === false){ iframeTerminalSetup(); }
      } else {
        nav.stop().animate({ height: '0' }, animateTime);
        $("#terminal_frame_box").removeClass("bottomMargin");
      }
    });
});

// activate collapse right menu when the windows is resized
$(window).resize(function(){
    if($(window).width() <= 991){
        pd.initRightMenu();
    }
});

pd = {
    misc:{
        navbar_menu_visible: 0
    },
    checkScrollForTransparentNavbar: debounce(function() {
        if($(document).scrollTop() > 381 ) {
            if(transparent) {
                transparent = false;
                $('.navbar-color-on-scroll').removeClass('navbar-transparent');
                $('.navbar-title').removeClass('hidden');
            }
        } else {
            if( !transparent ) {
                transparent = true;
                $('.navbar-color-on-scroll').addClass('navbar-transparent');
                $('.navbar-title').addClass('hidden');
            }
        }
    }),
    initRightMenu: function(){
         if(!navbar_initialized){
            $off_canvas_sidebar = $('nav').find('.navbar-collapse').first().clone(true);

            $sidebar = $('.sidebar');
            sidebar_bg_color = $sidebar.data('background-color');
            sidebar_active_color = $sidebar.data('active-color');

            $logo = $sidebar.find('.logo').first();
            logo_content = $logo[0].outerHTML;

            ul_content = '';

            // set the bg color and active color from the default sidebar to the off canvas sidebar;
            $off_canvas_sidebar.attr('data-background-color',sidebar_bg_color);
            $off_canvas_sidebar.attr('data-active-color',sidebar_active_color);

            $off_canvas_sidebar.addClass('off-canvas-sidebar');

            //add the content from the regular header to the right menu
            $off_canvas_sidebar.children('ul').each(function(){
                content_buff = $(this).html();
                ul_content = ul_content + content_buff;
            });

            // add the content from the sidebar to the right menu
            content_buff = $sidebar.find('.nav').html();
            ul_content = ul_content + '<li class="divider"></li>'+ content_buff;

            ul_content = '<ul class="nav navbar-nav">' + ul_content + '</ul>';

            navbar_content = logo_content + ul_content;
            navbar_content = '<div class="sidebar-wrapper">' + navbar_content + '</div>';

            $off_canvas_sidebar.html(navbar_content);

            $('body').append($off_canvas_sidebar);

             $toggle = $('.navbar-toggle');

             $off_canvas_sidebar.find('a').removeClass('btn btn-round btn-default');
             $off_canvas_sidebar.find('button').removeClass('btn-round btn-fill btn-info btn-primary btn-success btn-danger btn-warning btn-neutral');
             $off_canvas_sidebar.find('button').addClass('btn-simple btn-block');

             $toggle.click(function (){
                if(pd.misc.navbar_menu_visible == 1) {
                    $('html').removeClass('nav-open');
                    pd.misc.navbar_menu_visible = 0;
                    $('#bodyClick').remove();
                     setTimeout(function(){
                        $toggle.removeClass('toggled');
                     }, 400);

                } else {
                    setTimeout(function(){
                        $toggle.addClass('toggled');
                    }, 430);

                    div = '<div id="bodyClick"></div>';
                    $(div).appendTo("body").click(function() {
                        $('html').removeClass('nav-open');
                        pd.misc.navbar_menu_visible = 0;
                        $('#bodyClick').remove();
                         setTimeout(function(){
                            $toggle.removeClass('toggled');
                         }, 400);
                    });

                    $('html').addClass('nav-open');
                    pd.misc.navbar_menu_visible = 1;

                }
            });
            navbar_initialized = true;
        }

    }
}


// Returns a function, that, as long as it continues to be invoked, will not
// be triggered. The function will be called after it stops being called for
// N milliseconds. If `immediate` is passed, trigger the function on the
// leading edge, instead of the trailing.

function debounce(func, wait, immediate) {
	var timeout;
	return function() {
		var context = this, args = arguments;
		clearTimeout(timeout);
		timeout = setTimeout(function() {
			timeout = null;
			if (!immediate) func.apply(context, args);
		}, wait);
		if (immediate && !timeout) func.apply(context, args);
	};
};
