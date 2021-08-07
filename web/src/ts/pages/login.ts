import ApiReq from '../modules/apiReq.js'
import FieldRow from '../modules/field-row.js'
import Token from '../modules/token.js'
import _ from '../modules/queryLight.js'

_('.auth__form').on('submit', tryLogin)



function tryLogin(evt) {
  evt.preventDefault()
  FieldRow.clearAllErrors()

  this.addClass('auth__form_loading')
  ApiReq.send('login', 'post', this.formData()).then(handleResponse.bind(this))
}

function handleResponse(response) {
  this.removeClass('auth__form_loading')

  if (response.error) loginFailed(response.error)
  else loginSuccess(response.data)
}

function loginFailed(error) {
  error.code === 422 && Object.keys(error.errors).forEach(key => FieldRow.setError(key, error.errors[key]))
}

function loginSuccess(data) {
  Token.set(data.token)
  location.href = '/home.html'
}
