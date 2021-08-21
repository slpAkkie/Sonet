import createTemplate from './template.js'
import q from './queryLight.js'

export interface PopupButton {
  text: string
  classes?: Array<string>
  callback: Function
}

export class Popup {
  /**
   * Insert buttons into the popup footer
   *
   * @param {HTMLElement} popup
   * @param {Array<PopupButton>} buttons
   * @returns
   */
  static insertButtons(popup: HTMLElement, buttons: Array<PopupButton>) {
    let popupFooter = q('.o-popup__footer', popup)

    buttons.forEach(button => {
      let butttonEl = <HTMLElement>createTemplate(`<input class="o-btn o-btn--sm" type="button" value="${button.text}"/>`)
      if (button.classes) {
        button.classes.forEach(className => butttonEl.classList.add(`o-btn--${className}`))
      }

      q(popupFooter.insert(butttonEl)).on('click', button.callback.bind(butttonEl))
    })

    return popup
  }

  /**
   * Open popup window for confirmation
   *
   * @param {string} content
   * @param {Array<PopupButton>} buttons
   */
  static show(content: string, buttons: Array<PopupButton>): void {
    document.body.appendChild(
      this.insertButtons(<HTMLElement>createTemplate(
        `<div class="o-popup">
          <div class="o-popup__inner">
            <div class="o-popup__content">
              <div class="o-popup__body">${content}</div>
              <div class="o-popup__footer"></div>
            </div>
          </div>
        </div>`
      ), buttons)
    )
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
