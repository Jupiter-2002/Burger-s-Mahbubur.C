function mainmenu(){
  "use strict";
  jQuery("#main-menu ul:first li").hover(function(){
    jQuery(this).find('ul:first').stop().fadeIn('slow');
  },function(){
    jQuery(this).find('ul:first').stop().fadeOut('fast');
  });
}

function applyIso(){
  "use strict";
  jQuery("div.portfolio-container").css({overflow:'hidden'}).isotope({itemSelector : '.isotope-item'});
}

function animateSkillBars(){
  "use strict";
  var applyViewPort = ( jQuery("html").hasClass('csstransforms') ) ? ":in-viewport" : "";
  jQuery('.progress'+applyViewPort).each(function(){
    var progressBar = jQuery(this),
        progressValue = progressBar.find('.bar').attr('data-value');
    
    if (!progressBar.hasClass('animated')) {
      progressBar.addClass('animated');
      progressBar.find('.bar').animate({width: progressValue + "%"},600,function(){ progressBar.find('.bar-text').fadeIn(400); });
    }
    
  });
}



jQuery(document).ready(function(){
  "use strict";
  mainmenu();
  
  animateSkillBars();
  
  jQuery(window).scroll(function(){ animateSkillBars(); });
  
  /* Main Menu */
  jQuery("#main-menu ul li:has(ul)").each(function(){
    jQuery(this).addClass("hasSubmenu");
  });
  
  /* Mibile Nav */
  jQuery('#main-menu > ul').mobileMenu({
    defaultText: 'Navigate to...',
    className: 'mobile-menu',
    subMenuDash: '&ndash;&nbsp;'
  });

});