import q from './queryLight.js'

export default class FieldRow {
  static setError(field_ID: string, error_message: Array<string>): void {
    q(`.o-field-row__error[data-for=${field_ID}]`)?.addClass('o-field-row__error--shown').text(error_message.join(', '))
  }

  static removeError(field_ID: string): void {
    q(`.o-field-row__error[data-for=${field_ID}]`)?.removeClass('o-field-row__error--shown').text('')
  }

  static clearAllErrors(): void {
    q('.o-field-row__error--shown')?.removeClass('o-field-row__error--shown').text('')
  }
}
