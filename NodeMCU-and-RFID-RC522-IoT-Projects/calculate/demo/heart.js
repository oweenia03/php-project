src="https://code.jquery.com/jquery-3.6.0.min.js"
function likeAnimationButton() {
    var element = document.querySelector('#Night _Day');
    element.classList.add('animate-like');
    setTimeout(function(){
      element.classList.remove('animate-like');
    }, 650); 
  }

  $(function(){
      $(document).one('click', '.like-review', function(e) {
        $(this).html('<i class="fa fa-heart" aria-hidden="true"></i> You liked this');
        $(this).children('.fa-heart').addClass('animate-like');
      });
    });