/**
 * TODO: Разбить на класс Note
 */

class App {
  /**
   * Класс App отвечает за управлением всем приложением
   */

  constructor() {
    /**
     * Инициализируем необходимые переменные
     */

    // Определяем переменные для списка заметок
    this.noteList = $(`#js-notesList`);
    this.middleCollapsing = $(`#js-collapseMiddle`);

    // Определяем поле редактирования текста
    this.editorTitle = $(`#js-editorTitle`);
    this.editorFrame = $(`#js-editorFrame`)[0];
    this.editorFrameDoc = this.editorFrame.contentDocument;
    this.editorFrameWin = this.editorFrame.contentWindow;
    /** Немного переопределим фрейм */
    this.editorFrame = $($(`#js-editorFrame`)[0]);

    // Элементы форматирования текста
    this.formattingTools = $(`#js-formattingTools`);
    this.activeNote = false;

    /**
     * Выполняем необходимые действия
     */
    /** Инициализируем фрейм */
    this.initilizeFrame();
    /** Инициализируем обработчики событий */
    this.initilizeHandlers();
    // Прячем прелоадер
    this.hidePreloader();
  }

  initilizeFrame() {
    /**
     * Инициализация Фрейм - Создание его разметки, запись и активация режима проектирования
     */

    /** TODO: Здесь мы подгружаем данные о нашей заметке */
    // this.note.loadNote();
    // let nTitle = this.note.title;
    // let nContent = this.note.content;

    const iHTML = `<html><head><link rel="stylesheet" href="css/main.min.css"></head><body class="w-placeholder" id="js-frameBody" data-text="Тело заметки"></body></html>`;
    this.editorFrameDoc.open();
    this.editorFrameDoc.write(iHTML);
    this.editorFrameDoc.close();
    this.editorFrameDoc.designMode = `on`;

    // Обновляем содержимое body фрейма
    this.editorFrameBody = this.editorFrameDoc.body;
  }

  initilizeHandlers() {
    /**
     * Инициализируем базовые обработчики событий
     */

    /**
     * Клик по заметке
     */
    $(`.list__item`).click(function () { _app.openNote(this) });

    /**
     * Клик на кнопки форматирования
     */
    $(`.editor__formatting-tool`).mousedown(function () { return _app.formatText(this); });

    /**
     * Нажатие кнопки внутри Фрейма и перевод фокуса на окно редактирования
     */
    $(this.editorFrameBody).keyup(function () { _app.frameInterection(); _app.updateFormattingButton() })
      .focusout(function () { _app.frameInterection(false) })
      .focusin(function () { _app.frameInterection(true) })
      .mouseup(function () { _app.updateFormattingButton() });

    $(`#js-openSettings`).mousedown(() => { return false })
      .click(() => { _app.openSettings() });
    $(`#js-closeSettings`).click(() => { this.closeSettings() });

    $(`#js-isProtect`).click(function () { _app.changeProtect(this) });

    $(`#js-formattingTools`).mousedown(() => { return false });
  }

  hidePreloader() {
    /**
     * Прячем прелоадер с задержкой в 500мс
     */
    setTimeout(() => { $(`#js-preloader`).addClass(`hidden`) }, 500);
  }

  openNote(clickedNote) {
    /**
     * Если выбранная заметка уже была открыта (имеет класс active), то
     * Закроем поле редактирования и удалим класс active
     *
     * Иначе откроем поле редактирования и добавим класс выбранной заметке active
     */

    /** TODO: Здесь подгружается Фрейм с содержимым заметки, реализовать методы:
     * this.noteId = this.activeNote.attr(`data-id`);
     * this.reloadFrame();
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
  }

  openSettings() { $(`#js-collapseRight`).removeClass(`hidden`) }

  closeSettings() {
    $(`#js-collapseRight`).addClass(`hidden`);
    this.editorFrameBody.focus();
  }

  changeProtect(switcher) {
    // TODO: Изменить схему становления защищенной через класс Note
    switcher = $(switcher);
    if (switcher.hasClass(`active`)) switcher.removeClass(`active`)
    else switcher.addClass(`active`);
  }

  frameInterection(isFocus = true) {
    /**
     * Обработчик нажатия кнопок внутри фрейма
     */

    /** Если после изменения фрейма он стал пустым, убрать блок с кнопками форматирования, иначе показать его */
    if (this.editorFrameBody.innerHTML && isFocus) {
      this.formattingTools.removeClass(`hidden`);
      this.editorFrame.addClass(`frame-short`);
    } else {
      this.formattingTools.addClass(`hidden`);
      this.editorFrame.removeClass(`frame-short`);
    }
  }

  formatText(tool) {
    /**
     * Обработчик кнопок форматирования
     */
    tool = $(tool);

    this.editorFrameWin.focus();
    const action = tool.attr(`data-action`);                     // Действие для обработки текста
    const param = tool.attr(`data-param`) || null;               // Параметры если есть
    this.editorFrameDoc.execCommand(action, false, param);       // Выполняем команду с указанным действием и параметрами

    tool.hasClass(`active`) ? tool.removeClass(`active`) : tool.addClass(`active`);
    // this.editorFrameBody.focus();
    // this.updateFormattingButton();
    // Прерываем стандартное поведение, что бы не потерять фокус
    return false;
  }

  getTags() {
    let tagQueue = this.editorFrameDoc.getSelection().focusNode.parentElement;
    let tagArray = [];
    while (![`body`, `html`].includes(tagQueue.localName)) {
      tagArray.push(tagQueue.localName);
      tagQueue = tagQueue.parentElement;
    }
    return tagArray;
  }

  updateFormattingButton() {
    let tags = this.getTags();
    let bBold = $(`#js-bold`);
    let bItalic = $(`#js-italic`);
    let bUnderline = $(`#js-inderline`);
    tags.includes(`b`) ? bBold.addClass(`active`) : bBold.removeClass(`active`);
    tags.includes(`i`) ? bItalic.addClass(`active`) : bItalic.removeClass(`active`);
    tags.includes(`u`) ? bUnderline.addClass(`active`) : bUnderline.removeClass(`active`);
  }
}

/** Инициализируем объект приложения */
_app = new App;
