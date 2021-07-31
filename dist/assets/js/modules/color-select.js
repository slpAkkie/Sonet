var __classPrivateFieldGet = (this && this.__classPrivateFieldGet) || function (receiver, state, kind, f) {
    if (kind === "a" && !f) throw new TypeError("Private accessor was defined without a getter");
    if (typeof state === "function" ? receiver !== state || !f : !state.has(receiver)) throw new TypeError("Cannot read private member from an object whose class did not declare it");
    return kind === "m" ? f : kind === "a" ? f.call(receiver) : f ? f.value : state.get(receiver);
};
var _a, _ColorSelect_closeAllDropDown, _ColorSelect_toggleDropDown;
export class ColorSelect {
    /**
     * Add the event listener to the document
     *
     * @returns {void}
     */
    static init() {
        document.addEventListener('click', this.selectedValue_click.bind(this));
    }
    /**
     * Hanle click on document
     *
     * @param {Event} evt
     * @returns {void}
     */
    static selectedValue_click(evt) {
        // Check if click was dispatched on the selected value
        const isSelectedValue = evt.target.closest('.color-select__selected-value');
        if (!isSelectedValue) {
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
}
_a = ColorSelect, _ColorSelect_closeAllDropDown = function _ColorSelect_closeAllDropDown() {
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
