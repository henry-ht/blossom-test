import '../css/app.css'
import Alpine from 'alpinejs'
import axios from 'axios'
import { createIcons, icons } from 'lucide'

axios.defaults.baseURL = window.location.origin
axios.defaults.headers.common['Accept'] = 'application/json'
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

Alpine.magic('http', () => axios)
Alpine.magic('csrf', () => {
  const meta = document.querySelector('meta[name="csrf-token"]')
  return meta?.getAttribute('content') ?? ''
})

document.addEventListener('alpine:init', () => {
  Alpine.effect(() => {
    Alpine.nextTick(() => createIcons({ icons, attrs: { 'stroke-width': 1.5 } }))
  })
})

window.Alpine = Alpine
Alpine.start()
