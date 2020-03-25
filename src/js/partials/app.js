/**
 * TODO: Разбить на класс Note
 */

class App {
  /**
   * Класс App отвечает за управлением всем приложением
   */

  constructor() {
    /**
     * Инициализируем необходимые элементы
     */

    this.hidePreloader();

    this.noteList = $(`#js-notesList`);
    this.middleCollapsing = $(`#js-collapseMiddle`);

    this.editorTitle = $(`#js-editorTitle`);
    this.editorFrame = $(`#js-editorFrame`)[0];
    this.editorFrameDoc = this.editorFrame.contentDocument;
    this.editorFrameWin = this.editorFrame.contentWindow;
    /** Немного переопределим переменную фрейма */
    this.editorFrame = $($(`#js-editorFrame`)[0]);

    this.formattingTools = $(`#js-formattingTools`);
    this.activeNote = false;

    /** Инициализируем фрейм */
    this.initilizeFrame();
    /** Инициализируем обработчики событий */
    this.initilizeHandlers();
  }

  hidePreloader() {
    setTimeout(() => { $(`#js-preloader`).addClass(`hidden`) }, 500);
  }

  initilizeFrame() {
    /**
     * Инициализация Фрейм - Создание его разметки, запись и активация режима проектирования
     */

    /** TODO: Здесь мы подгружаем нашу заметку */
    // this.note.loadNote();

    const iHTML = `<html><head><link rel="stylesheet" href="css/main.min.css"></head><body class="w-placeholder" id="js-frameBody" data-text="Тело заметки"></body></html>`;
    this.editorFrameDoc.open();
    this.editorFrameDoc.write(iHTML);
    this.editorFrameDoc.close();
    this.editorFrameDoc.designMode = `on`;

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
    $(this.editorFrameBody).keyup(function () { _app.frameInterection() });
    $(this.editorFrameBody).focusout(function () { _app.frameInterection(false) });
    $(this.editorFrameBody).focusin(function () { _app.frameInterection(true) });

    $(`#js-openSettings`).click(function () { _app.openSettings() });
    $(`#js-closeSettings`).click(function () { _app.closeSettings() });

    $(`#js-isProtect`).click(function () { _app.changeProtect(this) });
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
    this.editorFrameBody.focus()
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

    this.editorFrameWin.focus();
    const action = $(tool).attr(`data-action`);                     // Действие для обработки текста
    const param = $(tool).attr(`data-param`) || null;               // Параметры если есть
    this.editorFrameDoc.execCommand(action, false, param);          // Выполняем команду с указанным действием и параметрами
    // Прерываем стандартное поведение, что бы не потерять фокус
    return false;
  }
}

/** Инициализируем объект приложения */
_app = new App;
