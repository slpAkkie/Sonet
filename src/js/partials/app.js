'use strict';

$(`document`).ready(function () {

  $(`.strip-item`).click(function (e) {
    if ($(e.currentTarget).hasClass(`active`)) {
      $(`.middle-side`).addClass(`hidden`);
      $(e.currentTarget).removeClass(`active`);
    } else {
      $(`.middle-side`).removeClass(`hidden`);
      $(`.active`).removeClass(`active`);
      $(e.currentTarget).addClass(`active`);
    }
  });

  $(`#bold`).mousedown(function () {
    document.execCommand(`bold`, null, ``);
    return false;
  });
  $(`#italic`).mousedown(function () {
    document.execCommand(`italic`, null, ``);
    return false;
  });
  $(`#underline`).mousedown(function () {
    document.execCommand(`underline`, null, ``);
    return false;
  });
  $(`.text-content`).keyup(function () {
    if ($(`.text-content`).text()) {
      $(`.text-tools`).removeClass(`hidden`);
    } else {
      $(`.text-tools`).addClass(`hidden`);
    }
  });
});
