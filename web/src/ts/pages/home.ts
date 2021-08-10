import ColorSelect from '../modules/color-select.js'
import ApiReq from '../modules/apiReq.js'
import Token from '../modules/token.js'
import Note from '../modules/note.js'
import createTemplate from '../modules/template.js'
import _ from '../modules/queryLight.js'

ColorSelect.init()

_('.sidebar__exit').on('click', exit)

const logoutLoader = _('#logout-loader')
const pageBody = _('body')

const notesLoader = _('#notes-loader')
const notesContainer = _('.notes__container')

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

function handleSuccessNoteLoading(data: Array<Object>) {
  delete notesLoader.dataset.shown
  notesContainer.clear()
  if (data.length) notes = data.map(noteData => (new Note(noteData)).render(<HTMLElement>notesContainer.get()))
  else notesContainer.appendChild(createTemplate('<h5 class="page-view__sub-title mx-3">Ноутов нет, но вы можете создать их</h5>'))
}

ApiReq
  .send('notes', 'get', null, true)
  .then(response => {
    if (response.data) handleSuccessNoteLoading(response.data)
  })
