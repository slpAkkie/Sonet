import ColorSelect from '../modules/color-select.js'
import ApiReq from '../modules/apiReq.js'
import Token from '../modules/token.js'
import _ from '../modules/queryLight.js'

ColorSelect.init()

_('.sidebar__exit').on('click', exit)

const pageLoader = _('.loader')
const pageBody = _('body')

function exit() {
  pageLoader.dataset.shown = true
  pageBody.addClass('scroll-fix')
  ApiReq
    .send('logout', 'delete', null, true)
    .then(response => {
      if (response.data) {
        Token.clear()
        location.href = '/login.html'
      } else {
        delete pageLoader.dataset.shown
        pageBody.removeClass('scroll-fix')
      }
    })
}
