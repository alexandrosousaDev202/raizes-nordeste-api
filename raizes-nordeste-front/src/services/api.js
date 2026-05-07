import axios from 'axios';

const api = axios.create({
  baseURL: 'http://localhost:8080',
});

api.interceptors.request.use(async (config) => {
  const token = localStorage.getItem('@RaizesToken');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

api.interceptors.response.use(
  (response) => {
    return response;
  },
  (error) => {
    if (error.response && error.response.status === 401 && window.location.pathname !== '/') {
        localStorage.removeItem('@RaizesToken');
        window.location.href = '/';
    }
    
    return Promise.reject(error);
  }
);

export default api;