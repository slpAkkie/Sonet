import { ColorSelect } from '../modules/color-select.js'
import { ApiReq } from '../modules/apiReq.js'
import { Token } from '../modules/token.js'
import { Note } from '../modules/note.js'
import { FieldRow } from '../modules/field-row.js'
import createTemplate from '../modules/template.js'
import q from '../modules/queryLight.js'

ColorSelect.init()

const addForm = q('.add-form')

q('.c-sidebar__exit').on('click', exit)
addForm.on('submit', tryCreate)

const logoutLoader = q('#logout-loader')
const pageBody = q('body')

const notesLoader = q('#notes-loader')
const notesContainer = q('.notes__container')

const addFormLoader = q('#add-form-loader')

let notes = []

function exit() {
  logoutLoader.addClass('c-loader--shown')
  pageBody.addClass('scroll-fix')
  ApiReq
    .send('logout', 'delete', null, true)
    .then(response => {
      if (response.data || response.error.code === 401) {
        Token.clear()
        location.href = '/login.html'
      } else {
        logoutLoader.removeClass('c-loader--shown')
        pageBody.removeClass('scroll-fix')
      }
    })
}

function tryCreate(evt) {
  evt.preventDefault()

  addFormLoader.addClass('c-loader--shown')
  let formData = Object.assign(
    q(this).formData(),
    {
      meta: {
        color: q('.o-color-select__selected-color', this).dataset.color || 'transparent'
      }
    }
  )

  ApiReq
    .send('notes', 'post', <BodyInit>formData, true)
    .then(response => {
      addFormLoader.removeClass('c-loader--shown')

      if (response.data) handleSuccessNoteCreating(response.data)
      else if (response.error) handleNoteCreatingError(response.error)
    })
}

function handleSuccessNoteLoading(data: Array<Object>) {
  notesContainer.clear()
  if (data.length) notes = data.map(noteData => new Note(noteData).render(notesContainer))
  else notesContainer.appendChild(createTemplate(`<h5 class='page__sub-title u-margin-x-3'>Ноутов нет, но вы можете создать их</h5>`))
}

function handleSuccessNoteCreating(data: Object) {
  notesContainer.child('.page__sub-title')?.remove()
  addForm.reset()
  new Note(data).render(notesContainer)
}

function handleNoteCreatingError(error) {
  if (error.code === 422) Object.keys(error.errors).forEach(key => FieldRow.setError(key, error.errors[key]))
  else if (error.code === 401) exit()
}

function loadNotes() {
  ApiReq
    .send('notes', 'get', null, true)
    .then(response => {
      notesLoader.removeClass('c-loader--shown')

      if (response.data) handleSuccessNoteLoading(response.data)
      else if (response.error.code === 401) exit()
    })
}

loadNotes()
