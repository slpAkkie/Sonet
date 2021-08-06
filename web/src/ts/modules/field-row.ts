import _ from './queryLight.js'

export default class FieldRow {
  static setError(field_ID: string, error_message: Array<string>): void {
    _(`.field-row__error[data-for=${field_ID}]`)?.addClass('field-row__error_shown').text(error_message.join(', '))
  }

  static removeError(field_ID: string): void {
    _(`.field-row__error[data-for=${field_ID}]`)?.removeClass('field-row__error_shown').text('')
  }

  static clearAllErrors(): void {
    _('.field-row__error_shown')?.removeClass('field-row__error_shown').text('')
  }
}
