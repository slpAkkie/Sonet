export default function createTemplate(markup) {
  let template = document.createElement('template')
  template.innerHTML = markup.trim()

  return template.content.firstChild
}
