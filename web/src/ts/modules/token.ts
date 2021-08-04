import { Store } from './store.js'

export class Token {
  static storeKey = 'api_token'

  static token?: string = null

  static check(): boolean {
    return !!this.get()
  }

  static get(): string {
    return this.token || (this.token = Store.get(this.storeKey))
  }

  static set(token): string {
    return this.token = Store.set(this.storeKey, token)
  }

  static clear(): void {
    Store.rm(this.storeKey)
  }
}
