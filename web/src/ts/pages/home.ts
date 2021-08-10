import ColorSelect from '../modules/color-select.js'
import ApiReq from '../modules/apiReq.js'
import Token from '../modules/token.js'
import Note from '../modules/note.js'
import createTemplate from '../modules/template.js'
import FieldRow from '../modules/field-row.js'
import _ from '../modules/queryLight.js'

ColorSelect.init()

const addForm = _('.add-form')

_('.sidebar__exit').on('click', exit)
addForm.on('submit', tryCreate)

const logoutLoader = _('#logout-loader')
const pageBody = _('body')

const notesLoader = _('#notes-loader')
const notesContainer = _('.notes__container')

const addFormLoader = _('#add-form-loader')

let notes = []

function exit() {
  logoutLoader.dataset.shown = true
  pageBody.addClass('scroll-fix')
  ApiReq
    .send('logout', 'delete', null, true)
    .then(response => {
      if (response.data) {
        Token.clear()
        location.href = '/login.html'
      } else {
        delete logoutLoader.dataset.shown
        pageBody.removeClass('scroll-fix')
      }
    })
}

function tryCreate(evt) {
  evt.preventDefault()

  addFormLoader.dataset.shown = 'true'
  let formData = Object.assign(
    _(this).formData(),
    {
      meta: {
        color: _('.color-select__selected-color', this).dataset.color || 'transparent'
      }
    }
  )

  ApiReq
    .send('notes', 'post', <BodyInit>formData, true)
    .then(response => {
      delete addFormLoader.dataset.shown

      if (response.data) handleCreatedNote(response.data)
      else if (response.error) handleCreatingError(response.error)
    })
}

function handleSuccessNoteLoading(data: Array<Object>) {
  delete notesLoader.dataset.shown
  notesContainer.clear()
  if (data.length) notes = data.map(noteData => new Note(noteData).render(notesContainer))
  else notesContainer.appendChild(createTemplate('<h5 class="page-view__sub-title mx-3">Ноутов нет, но вы можете создать их</h5>'))
}

function handleCreatedNote(data: Object) {
  notesContainer.child('.page-view__sub-title')?.remove()
  addForm.reset()
  new Note(data).render(notesContainer)
}

function handleCreatingError(error) {
  error.code === 422 && Object.keys(error.errors).forEach(key => FieldRow.setError(key, error.errors[key]))
}

function loadNotes() {
  ApiReq
    .send('notes', 'get', null, true)
    .then(response => {
      if (response.data) handleSuccessNoteLoading(response.data)
    })
}

loadNotes()
