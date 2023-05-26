// setTimeout(function() {
//     var successDiv = document.getElementById('success-alert');
//     successDiv.parentNode.removeChild(successDiv);
//   }, 5000); // Remove the div after 5 seconds (5000 milliseconds)

// Created for an Articles on:
// https://www.html5andbeyond.com/bubbling-text-effect-no-canvas-required/

jQuery(document).ready(function($){
 
  // Define a blank array for the effect positions. This will be populated based on width of the title.
  var bArray = [];
  // Define a size array, this will be used to vary bubble sizes
  var sArray = [4,6,8,10];

  // Push the header width values to bArray
  for (var i = 0; i < $('.bubbles').width(); i++) {
      bArray.push(i);
  }
   
  // Function to select random array element
  // Used within the setInterval a few times
  function randomValue(arr) {
      return arr[Math.floor(Math.random() * arr.length)];
  }

  // setInterval function used to create new bubble every 350 milliseconds
  setInterval(function(){
       
      // Get a random size, defined as variable so it can be used for both width and height
      var size = randomValue(sArray);
      // New bubble appeneded to div with it's size and left position being set inline
      // Left value is set through getting a random value from bArray
      $('.bubbles').append('<div class="individual-bubble" style="left: ' + randomValue(bArray) + 'px; width: ' + size + 'px; height:' + size + 'px;"></div>');
       
      // Animate each bubble to the top (bottom 100%) and reduce opacity as it moves
      // Callback function used to remove finsihed animations from the page
      $('.individual-bubble').animate({
          'bottom': '100%',
          'opacity' : '-=0.7'
      }, 3000, function(){
          $(this).remove()
      }
      );


  }, 350);
//about us
var   words = [' B&S  ', ' your Home'],
    part,
    i = 0,
    offset = 0,
    len = words.length,
    forwards = true,
    skip_count = 0,
    skip_delay = 5,
    speed = 100;

  var wordflick = function () {
    setInterval(function () {
      if (forwards) {
        if (offset >= words[i].length) {
          ++skip_count;
          if (skip_count == skip_delay) {
            forwards = false;
            skip_count = 0;
          }
        }
      }
      else {
        if (offset == 0) {
          forwards = true;
          i++;
          offset = 0;
          if (i >= len) {
            i = 0;
          }
        }
      }
      part = words[i].substr(0, offset);
      if (skip_count == 0) {
        if (forwards) {
          offset++;
        }
        else {
          offset--;
        }
      }
      $('.word').text(part);
    }, speed);
  };


  wordflick();

});

$('.header').ready(function(){

    //scroll
    $(window).on('scroll',function(){
        var scroll = $(window).scrollTop();
        if(scroll>=50){
            $(".sticky").addClass("stickyadd");
        }else{
            $(".sticky").removeClass("stickyadd");
        }

    })
    
});



$(document).ready(function() {
  $('#search-item').on('keyup', function() {
    var input = $(this).val().toLowerCase();
    $('.card.home-card').each(function() {
      var itemName = $(this).find('.card-title').text().toLowerCase();
      var cardContainer = $(this).closest('.searched');
      if (itemName.includes(input)) {
        cardContainer.show();
      } else {
        cardContainer.hide();
      }
    });
  });
});

$(document).ready(function() {
  $('#search-item-nav').on('keyup', function() {
    var input = $(this).val().toLowerCase();
    $('.card.home-card').each(function() {
      var itemName = $(this).find('.card-title').text().toLowerCase();
      var cardContainer = $(this).closest('.searched');
      if (itemName.includes(input)) {
        cardContainer.show();
      } else {
        cardContainer.hide();
      }
    });
  });
});

$(document).ready(function() {
  $(".add-to-cart").click(function() {
    // Check if the user is logged in
    var isLoggedIn = checkLoginStatus(); // Replace this with your login status check

    if (isLoggedIn) {
      // Add item to cart logic here
      alert("Item added to cart successfully!");
    } else {
      // Show login condition
      $("#login-condition").show();
    }
  });
  $(".Buy-now").click(function() {
    // Check if the user is logged in
    var isLoggedIn = checkLoginStatus(); // Replace this with your login status check

    if (isLoggedIn) {
      // Add item to cart logic here
      alert("Item added to cart successfully!");
    } else {
      // Show login condition
      $("#login-condition").show();
    }
  });

  // Close the login condition when the "Close" button is clicked
  $("#close-button").click(function() {
    $("#login-condition").hide();
  });

  // Example login status check function
  function checkLoginStatus() {
    // Replace this with your own login status check logic
    // Return true if the user is logged in, false otherwise
    return false; // Change to true for testing
  }
});

// profile

(function($){
  $.fn.textAnimation = function(animation_speed, text_speed, animation) {
    var text, i = 0;
    var $this = $(this);

    // Store text and clear
    text = $this.text();
    $this.css('white-space', 'pre');
    $this.html('');

    var addLetter = setInterval(function() {
      $this.append('<div class="text_animation" style="display: inline-block; animation: ' + animation + ' ' + animation_speed + 'ms forwards">' + text[i] + '</div>');
      i++;
      if (i == text.length) clearInterval(addLetter);
    }, text_speed);
  };
})(jQuery);

var temp = $('.bounce_in_animation').text();
var i = 1;

$('.bounce_in_animation').textAnimation(250, 50, 'bounceIn');

setInterval(function() {
  i %= 4;
  $('.bounce_in_animation').html(temp);
  switch (i) {
    case 0:
      $('.bounce_in_animation').textAnimation(250, 50, 'bounceIn');
      break;
    case 1:
      $('.bounce_in_animation').textAnimation(250, 50, 'slideDown');
      break;
    case 2:
      $('.bounce_in_animation').textAnimation(250, 50, 'slideUp');
      break;
    default:
      $('.bounce_in_animation').textAnimation(250, 50, 'spinIn');
  }
  i++;
}, 1000 + 50 * temp.length + 250);
