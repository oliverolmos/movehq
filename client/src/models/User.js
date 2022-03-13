import JwtDecode from 'jwt-decode'

export default class User {
  static from (token) {
    try {
      let obj = JwtDecode(token)
      console.log("User Obj", obj)
      return new User(obj.data)
    } catch (_) {
      return null
    }
  }

  constructor ({id, email, name, admin, img, status}) {
    
    this.id = id // eslint-disable-line camelcase
	this.email = email
	this.name = name
    this.admin = admin
    this.img = img
    this.status = status

  }

  get isAdmin () {
    return this.admin
  }
}