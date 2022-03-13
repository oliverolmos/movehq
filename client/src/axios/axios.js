import axios from 'axios'

const cfg = require('../../../global_conf.json')
const API_URL = process.env.API_URL || cfg.backend_url
export default axios.create({
  baseURL: API_URL,
  headers: {
    'Content-Type': 'application/x-www-form-urlencoded'
  }
})
