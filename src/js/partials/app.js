'use strict';

/**
 * TODO: Разбить на класс Note
 */

// Ждем загрузки файла
$(`document`).ready(function () {

  class App {
    constructor() {
      this.noteList = $(`#js-notesList`);
      this.middleCollapsing = $(`#js-collapseMiddle`);
      this.editorTitle = $(`#js-editorTitle`);
      // this.editorFrame = document.getElementById(`js-editorFrame`);
      // this.editorFrameDoc = this.editorFrame.contentDocument;
      // this.editorFrameWin = this.editorFrame.contentWindow;
      this.editorFrame = $(`#js-editorFrame`)[0];
      this.editorFrameDoc = this.editorFrame.contentDocument;
      this.editorFrameWin = this.editorFrame.contentWindow;
      this.formattingTools = $(`#js-formattingTools`);
      this.activeNote = false;

      this.initilizeFrame();
      this.initilizeHandlers();
    }

    initilizeFrame() {
      /** TODO: Здесь мы подгружаем нашу заметку */
      // this.note.loadNote();

      const iHTML = `<html><head><link rel="stylesheet" href="css/main.min.css"></head><body class="w-placeholder" id="js-frameBody" data-text="Тело заметки"></body></html>`;
      this.editorFrameDoc.open();
      this.editorFrameDoc.write(iHTML);
      this.editorFrameDoc.close();
      this.editorFrameDoc.designMode = `on`;

      // Сохраняем body
      this.editorFrameBody = this.editorFrameDoc.body;
    }

    initilizeHandlers() {
      /**
       * Обработчик событий на клик по заметке
       */
      $(`.list__item`).click(function () { _app.openNote(this) });

      /**
       * Обработчик событий на элементы редактирования текста
       */
      $(`.editor__formatting-tool`).mousedown(function () { return _app.formatText(this); });

      // $(document.getElementsByTagName('iframe')[0].contentDocument.body).keyup(function () { console.log($(this)[0].innerHTML) })
      // $(this.editorFrameBody).keyup(function () { console.log($(this)[0].innerHTML) })

      /** Обработчик изменения frame`а */
      // $(this.editorFrameBody).keyup(this.frameChangeHandler);
      $(this.editorFrameBody).keyup(function () { _app.frameChangeHandler() })
    }

    openNote(clickedNote) {
      /**
       * Если выбранная заметка уже была открыта (имеет класс active)
       * закроем поле редактирования и удалим класс active
       *
       * Иначе откроем поле редактирования и добавим класс active
       */
      if ($(clickedNote).hasClass(`active`)) {
        $(this.middleCollapsing).addClass(`hidden`);
        this.activeNote.removeClass(`active`),
          this.activeNote = false;
      } else {
        $(this.middleCollapsing).removeClass(`hidden`);
        this.activeNote ? this.activeNote.removeClass(`active`) : false,
          this.activeNote = $(clickedNote);
        this.activeNote.addClass(`active`);
      }

      /** TODO: Здесь подгружается Фрейм с содержимым заметки */
      // this.noteId = this.activeNote.attr(`data-id`);
      // this.reloadFrame();
    }

    frameChangeHandler() {
      this.editorFrameBody.innerHTML ? this.formattingTools.removeClass('hidden') : this.formattingTools.addClass('hidden');
    }

    formatText(tool) {
      this.editorFrameWin.focus();
      const action = $(tool).attr(`data-action`);                     // Действие для обработки текста
      const param = $(tool).attr(`data-param`) || null;               // Параметры если есть
      this.editorFrameDoc.execCommand(action, false, param);          // Выполняем команду с указанным действием и параметрами
      // Прерываем стандартное поведение, что бы не потерять фокус
      return false;
    }
  }

  _app = new App;

  // TODO: Сделать создание фрейма и его обработку
});
