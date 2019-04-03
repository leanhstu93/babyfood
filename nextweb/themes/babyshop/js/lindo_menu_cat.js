$('[data-category-hover]').hover(function() {
  var el = $(this),
      dataHover = el.data('category-hover');
  $('[data-category-active]').removeClass('active');
  $('[data-category-active="' + dataHover + '"]').addClass('active');
  
  var activeHeight = $('[data-category-active="' + dataHover + '"]').height();
  $('[data-category-active]').parent('.lindo_category_bg .image-info').height(activeHeight);
});