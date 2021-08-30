import { q, qlWrapper } from './queryLight.js'
import { Popup } from './popup.js'
import createTemplate from './template.js'

export interface noteAuthorData {
  id: number
  nickname: string
}

export interface noteData {
  id: number
  title: string
  content?: string
  author: noteAuthorData
  meta: Record<string, any>
  created_at: string
}

export class Note {
  data: noteData

  constructor(data: Object) {
    this.data = <noteData>data
  }

  render(container: qlWrapper) {
    q(container.insertFirst(<HTMLElement>createTemplate(`
      <div class='o-note'>
        <div class='o-note__header'>
          <div class='o-note__title'><a class='o-note__title-link link_static js-note-title' href='#'>${this.data.title}</a></div>
          <div class='o-note__color' style='background-color: ${this.data.meta.color || 'transparent'}'></div>
        </div>
        <div class='o-note__content'>${this.data.content || ''}</div>
        <div class='o-note__footer'>
          <div class='o-note__created-at'>${this.data.created_at}</div>
          <div class='o-note__author'><a class='o-note__author-link' href='#'>${this.data.author.nickname}</a></div>
        </div>
      </div>`
    ))).child('.js-note-title').on('click', this.open.bind(this))

    return this
  }

  open() { }

}
