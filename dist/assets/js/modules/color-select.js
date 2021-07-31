var __classPrivateFieldGet = (this && this.__classPrivateFieldGet) || function (receiver, state, kind, f) {
    if (kind === "a" && !f) throw new TypeError("Private accessor was defined without a getter");
    if (typeof state === "function" ? receiver !== state || !f : !state.has(receiver)) throw new TypeError("Cannot read private member from an object whose class did not declare it");
    return kind === "m" ? f : kind === "a" ? f.call(receiver) : f ? f.value : state.get(receiver);
};
var _a, _ColorSelect_setData, _ColorSelect_getDataFromItem, _ColorSelect_getSelectElements, _ColorSelect_closeAllDropDown, _ColorSelect_toggleDropDown;
export class ColorSelect {
    /**
     * Add the event listener to the document
     *
     * @returns {void}
     */
    static init() {
        document.addEventListener('click', this.selectedValue_click.bind(this));
        document.addEventListener('click', this.listItem_click.bind(this));
    }
    /**
     * Hanle click on document
     *
     * @param {Event} evt
     * @returns {void}
     */
    static selectedValue_click(evt) {
        // Check if click was dispatched on the selected value
        const selectedValue = evt.target.closest('.color-select__selected-value');
        if (!selectedValue) {
            if (!this.openedDropDown)
                return;
            // If we have opened drop-down menu close it
            __classPrivateFieldGet(this, _a, "m", _ColorSelect_closeAllDropDown).call(this);
            return evt.preventDefault();
        }
        // Find color select element and the drop-down menu
        // and then toggle it's state
        const colorSelect = evt.target.closest('.color-select');
        const dropDown = colorSelect.querySelector('.color-select__drop-down');
        __classPrivateFieldGet(this, _a, "m", _ColorSelect_toggleDropDown).call(this, dropDown);
    }
    /**
     * Hanle click on color select list item
     *
     * @param {Event} evt
     * @returns {void}
     */
    static listItem_click(evt) {
        const listItem = evt.target.closest('.color-select__item');
        if (!listItem)
            return;
        __classPrivateFieldGet(this, _a, "m", _ColorSelect_setData).call(this, __classPrivateFieldGet(this, _a, "m", _ColorSelect_getDataFromItem).call(this, listItem), __classPrivateFieldGet(this, _a, "m", _ColorSelect_getSelectElements).call(this, listItem));
    }
}
_a = ColorSelect, _ColorSelect_setData = function _ColorSelect_setData(props, { selectedValue, selectedValueText, selectedValueColor }) {
    if (!props.color) {
        selectedValueColor.dataset.noColor = '';
    }
    else {
        delete selectedValueColor.dataset.noColor;
        selectedValueColor.style.backgroundColor = props.color;
    }
    selectedValueText.innerText = props.title;
    selectedValue.dataset.id = props.id;
}, _ColorSelect_getDataFromItem = function _ColorSelect_getDataFromItem(item) {
    return (({ color, title, id }) => ({
        color, title, id
    }))(item.dataset);
}, _ColorSelect_getSelectElements = function _ColorSelect_getSelectElements(listItem) {
    const selectedValue = listItem.closest('.color-select').querySelector('.color-select__selected-value');
    return {
        selectedValue,
        selectedValueText: selectedValue.querySelector('.color-select__selected-text'),
        selectedValueColor: selectedValue.querySelector('.color-select__selected-color'),
    };
}, _ColorSelect_closeAllDropDown = function _ColorSelect_closeAllDropDown() {
    delete this.openedDropDown.dataset.shown;
    this.openedDropDown = null;
}, _ColorSelect_toggleDropDown = function _ColorSelect_toggleDropDown(dropDown) {
    if (this.openedDropDown) {
        delete dropDown.dataset.shown;
        this.openedDropDown = null;
    }
    else {
        dropDown.dataset.shown = 'true';
        this.openedDropDown = dropDown;
    }
};
ColorSelect.openedDropDown = null;
