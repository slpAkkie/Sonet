import Token from './token.js'

export default class ApiReq {

  static #api_host: string = 'http://localhost:8000/api'

  /**
   * Send request to the api
   *
   * @param {string} api_method
   * @param {string} request_method
   * @param {Object} data
   * @param {boolean} need_token
   * @returns {Promise}
   */
  static send(api_method: string, request_method: string = 'get', body: BodyInit = <BodyInit>{}, need_token: boolean = false) {
    let opt: RequestInit = {
      method: request_method,
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(body)
    }

    if (need_token) opt.headers['Authorization'] = `Bearer ${Token.get()}`

    return fetch(`${this.#api_host}/${api_method}`, opt).then(response => {
      if (response.status === 204) return {
        data: true
      }
      return response.json()
    })
  }

}
