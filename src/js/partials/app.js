'use strict';

$(`document`).ready(function () {

  $(`.strip-item`).click(function (e) {
    if ($(e.currentTarget).hasClass(`active`)) {
      $(`#js-collapse-middle`).addClass(`hidden`);
      $(e.currentTarget).removeClass(`active`);
    } else {
      $(`#js-collapse-middle`).removeClass(`hidden`);
      $(`.active`).removeClass(`active`);
      $(e.currentTarget).addClass(`active`);
    }
  });

  $(`#js-bold`).mousedown(function () {
    document.execCommand(`bold`, null, ``);
    return false;
  });
  $(`#js-italic`).mousedown(function () {
    document.execCommand(`italic`, null, ``);
    return false;
  });
  $(`#js-underline`).mousedown(function () {
    document.execCommand(`underline`, null, ``);
    return false;
  });
  $(`#js-change`).keyup(function (e) {
    const jsSlide = $(`#js-slide`);
    if ($(e.currentTarget).text()) {
      jsSlide.removeClass(`hidden`);
    } else {
      jsSlide.addClass(`hidden`);
    }
  });
});
