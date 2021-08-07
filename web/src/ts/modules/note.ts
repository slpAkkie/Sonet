import createTemplate from './template.js'

interface noteAuthorData {
  id: number
  nickname: string
}

interface noteData {
  id: number
  title: string
  content?: string
  author: noteAuthorData
  meta: Record<string, any>
  created_at: string
}

export default class Note {
  data: noteData

  constructor(data: Object) {
    this.data = <noteData>data
  }

  render(container: HTMLElement) {
    container.appendChild(createTemplate(`<div class="note">
      <div class="note__header">
        <div class="note__title"><a class="note__title-link link_static" href="#">${this.data.title}</a></div>
        <div class="note__color" style="background-color: ${this.data.meta.color || 'transparent'}"></div>
      </div>
      <div class="note__content">${this.data.content}</div>
      <div class="note__footer">
        <div class="note__created-at">${this.data.created_at}</div>
        <div class="note__author"><a class="note__author-link" href="#">${this.data.author.nickname}</a></div>
      </div>
    </div>`))

    return this
  }

}
