import createTemplate from './template.js'
import { q, qlWrapper } from './queryLight.js'

export interface PopupButton {
  text: string
  classes?: Array<string>
  callback: Function
}

export class Popup {
  popupElement: qlWrapper

  constructor(content: string, buttons: Array<PopupButton>) {
    this.popupElement = q(<HTMLElement>createTemplate(
      `<div class="o-popup o-popup--shown">
        <div class="o-popup__inner">
          <div class="o-popup__content">
            <div class="o-popup__body">${content}</div>
            <div class="o-popup__footer"></div>
          </div>
        </div>
      </div>`))

    this.#insertButtons(buttons)

    q('.js-popup-container').insert(this.popupElement)
  }

  /**
   * Insert buttons into the popup footer
   *
   * @param {Array<PopupButton>} buttons
   * @returns {Popup}
   */
  #insertButtons(buttons: Array<PopupButton>): this {
    let popupFooter = this.popupElement.child('.o-popup__footer')

    buttons.forEach(button => {
      let butttonEl = <HTMLElement>createTemplate(`<input class="o-btn o-btn--sm" type="button" value="${button.text}"/>`)
      if (button.classes) {
        button.classes.forEach(className => butttonEl.classList.add(`o-btn--${className}`))
      }

      q(popupFooter.insert(butttonEl)).on('click', button.callback.bind(butttonEl, this))
    })

    return this
  }

  /**
   * Open popup window for confirmation
   *
   * @param {string} content
   * @param {Array<PopupButton>} buttons
   * @returns {Popup}
   */
  static show(content: string, buttons: Array<PopupButton>): Popup {
    return new this(content, buttons)
  }

  /**
   * Close opened popup
   */
  close() {
    this.popupElement.removeClass('o-popup--shown')
  }

  remove() {
    this.popupElement.rm()
  }

  /**
   * Show notice
   *
   * @param {string} content
   * @param {Function} callback
   */
  static notice(content: string, callback: Function): void {
    this.show(content, [{ text: 'Ok', callback }])
  }
}
