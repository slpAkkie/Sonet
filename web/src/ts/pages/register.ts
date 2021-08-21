import { ApiReq } from '../modules/apiReq.js'
import { FieldRow } from '../modules/field-row.js'
import q from '../modules/queryLight.js'

q('.auth__form').on('submit', tryRegister)

const loginLoader = q('#register-loader')



function tryRegister(evt) {
  evt.preventDefault()
  FieldRow.clearAllErrors()

  loginLoader.addClass('c-loader--shown')
  ApiReq.send('register', 'post', <BodyInit>q(this).formData()).then(handleResponse)
}

function handleResponse(response) {
  loginLoader.removeClass('c-loader--shown')

  if (response.error) registerFailed(response.error)
  else registerSuccess(response.data)
}

function registerFailed(error) {
  error.code === 422 && Object.keys(error.errors).forEach(key => FieldRow.setError(key, error.errors[key]))
}

function registerSuccess(data) {
  if (data) location.href = '/login.html'
}
