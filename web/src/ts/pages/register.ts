import ApiReq from '../modules/apiReq.js'
import FieldRow from '../modules/field-row.js'
import _ from '../modules/queryLight.js'

_('.auth__form').on('submit', tryRegister)



function tryRegister(evt) {
  evt.preventDefault()
  FieldRow.clearAllErrors()

  this.addClass('auth__form_loading')
  ApiReq.send('register', 'post', this.formData()).then(handleResponse.bind(this))
}

function handleResponse(response) {
  this.removeClass('auth__form_loading')

  if (response.error) registerFailed(response.error)
  else registerSuccess(response.data)
}

function registerFailed(error) {
  error.code === 422 && Object.keys(error.errors).forEach(key => FieldRow.setError(key, error.errors[key]))
}

function registerSuccess(data) {
  if (data) location.href = '/login'
}
