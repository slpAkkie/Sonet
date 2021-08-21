export class Store {
  /**
   * Set value to the localStorage
   * with specified key and returns it back
   *
   * @param {string} key
   * @param {any} value
   * @returns {any}
   */
  static set(key: string, value: any): any {
    localStorage.setItem(key, JSON.stringify({ data: value }))

    return value
  }

  /**
   * Get the value from the localStorage according to the specified key
   * and returns it or the default value
   *
   * @param {string} key
   * @param {any} def
   * @returns {any}
   */
  static get(key: string, def: any = null): any {
    let received = localStorage.getItem(key)

    return received ? JSON.parse(received).data || def : def
  }

  /**
   * Remove value from the localStorage according to the specified key
   * and returns that value
   *
   * @param {string} key
   * @returns {any}
   */
  static rm(key: string) {
    let value = this.get(key)
    localStorage.removeItem(key)

    return value
  }

  /**
   * Clear the localStorage
   *
   * @returns {void}
   */
  static prune(): void {
    localStorage.clear()
  }
}
