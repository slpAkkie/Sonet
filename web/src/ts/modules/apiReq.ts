import { Token } from './token.js'

export class ApiReq {

  static #api_origin?: string = null
  static #api_port: string = '8000'

  static get #origin() {
    return this.#api_origin || (this.#api_origin = location.origin.split(':').splice(0, 2).join(':'))
  }

  static get #host() {
    return `${this.#origin}:${this.#api_port}/api`
  }

  static #getMethodURI(api_method) {
    return `${this.#host}/${api_method}`
  }

  /**
   * Send request to the api
   *
   * @param {string} api_method
   * @param {string} request_method
   * @param {Object} data
   * @param {boolean} need_token
   * @returns {Promise}
   */
  static send(api_method: string, request_method: string = 'get', body: BodyInit = '', need_token: boolean = false) {
    let opt: RequestInit = {
      method: request_method,
      headers: {
        'Content-Type': 'application/json'
      },
      body: body && JSON.stringify(body)
    }

    if (need_token) opt.headers['Authorization'] = `Bearer ${Token.get()}`

    return fetch(this.#getMethodURI(api_method), opt)
      .then(response => {
        if (response.status === 204) return { data: true }

        return response.json()
      })
  }

}
