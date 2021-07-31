export class ColorSelect {
  static openedDropDown?: HTMLElement = null

  /**
   * Add the event listener to the document
   *
   * @returns {void}
   */
  static init(): void {
    document.addEventListener('click', this.selectedValue_click.bind(this))
  }

  /**
   * Hanle click on document
   *
   * @param {Event} evt
   * @returns {void}
   */
  static selectedValue_click(evt): void {
    // Check if click was dispatched on the selected value
    const isSelectedValue = (<HTMLElement>evt.target).closest('.color-select__selected-value')
    if (!isSelectedValue) {
      if (!this.openedDropDown) return

      // If we have opened drop-down menu close it
      this.#closeAllDropDown()
      return evt.preventDefault()
    }

    // Find color select element and the drop-down menu
    // and then toggle it's state
    const colorSelect = (<HTMLElement>evt.target).closest('.color-select')
    const dropDown = (<HTMLElement>colorSelect.querySelector('.color-select__drop-down'))

    this.#toggleDropDown(dropDown)
  }

  /**
   * Close all opened drop-down menus
   *
   * @returns {void}
   */
  static #closeAllDropDown(): void {
    delete this.openedDropDown.dataset.shown
    this.openedDropDown = null
  }

  /**
   * Toggle drop-down menu state
   *
   * @param {HTMLElement} dropDown
   * @returns {void}
   */
  static #toggleDropDown(dropDown): void {
    if (this.openedDropDown) {
      delete dropDown.dataset.shown
      this.openedDropDown = null
    } else {
      dropDown.dataset.shown = 'true'
      this.openedDropDown = dropDown
    }
  }
}
