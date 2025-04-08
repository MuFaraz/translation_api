
import axios from 'axios'

const api = axios.create({
    baseURL: 'http://localhost:8000/api', // Laravel backend
    withCredentials: true, // Required for Sanctum
})

export default api;
