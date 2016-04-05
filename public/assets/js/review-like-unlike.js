var likeUnlike = (function () {
  var $buttonLike,
    $buttonUnlike,

    _clickButton = function (e) {
      var $self = $(this),
        $buttons = $self.parent().find('a');
      if ($buttons.hasClass('active')) {
        $buttons.removeClass('active');
      }
      $self.addClass('active');
      e.preventDefault();
    };

    _init = function () {
      $buttonLike = $('.btn-like');
      $buttonUnlike = $('.btn-unlike');

      $buttonLike.click(_clickButton);
      $buttonUnlike.click(_clickButton);
    };

  return {
    init: _init
  }
})();

$('document').ready(function () {
  likeUnlike.init();
});
