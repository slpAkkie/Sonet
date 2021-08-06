interface ItemData {
  color: string
  title: string
  id: string
}

interface SelectElements {
  selectedValue: HTMLElement
  selectedValueText: HTMLElement
  selectedValueColor: HTMLElement
}



export default class ColorSelect {
  static openedDropDown?: HTMLElement = null

  /**
   * Add the event listener to the document
   *
   * @returns {void}
   */
  static init(): void {
    document.addEventListener('click', this.selectedValue_click.bind(this))
    document.addEventListener('click', this.listItem_click.bind(this))
  }

  /**
   * Hanle click on document
   *
   * @param {Event} evt
   * @returns {void}
   */
  static selectedValue_click(evt): void {
    // Check if click was dispatched on the selected value
    const selectedValue = (<HTMLElement>evt.target).closest('.color-select__selected-value')
    if (!selectedValue) {
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
   * Hanle click on color select list item
   *
   * @param {Event} evt
   * @returns {void}
   */
  static listItem_click(evt): void {
    const listItem = <HTMLElement>(<HTMLElement>evt.target).closest('.color-select__item')
    if (!listItem) return

    this.#setData(this.#getDataFromItem(listItem), this.#getSelectElements(listItem))
  }

  static #setData(props, { selectedValue, selectedValueText, selectedValueColor }) {
    if (!props.color) {
      selectedValueColor.dataset.noColor = ''
    } else {
      delete selectedValueColor.dataset.noColor
      selectedValueColor.style.backgroundColor = props.color
    }

    selectedValueText.innerText = props.title
    selectedValue.dataset.id = props.id
  }

  /**
   * Extract data from item dataset
   *
   * @param {HTMLElement} item
   * @returns {ItemData}
   */
  static #getDataFromItem(item): ItemData {
    return (({ color, title, id }) => ({
      color, title, id
    }))(item.dataset)
  }

  /**
   * Get color-select elements by list item
   *
   * @param {HTMLElement} listItem
   * @returns {SelectElements}
   */
  static #getSelectElements(listItem): SelectElements {
    const selectedValue = <HTMLElement>(<HTMLElement>listItem.closest('.color-select')).querySelector('.color-select__selected-value')

    return {
      selectedValue,
      selectedValueText: <HTMLElement>selectedValue.querySelector('.color-select__selected-text'),
      selectedValueColor: <HTMLElement>selectedValue.querySelector('.color-select__selected-color'),
    }
  }

  /**,
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
