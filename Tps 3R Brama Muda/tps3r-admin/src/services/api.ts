import axios, {
  type AxiosInstance,
  type AxiosError,
  type InternalAxiosRequestConfig,
  type AxiosResponse
} from 'axios';

const BASE_URL = 'http://127.0.0.1:8000/api';

export const STORAGE_KEYS = {
  TOKEN: 'tps3r_token',
  USER: 'tps3r_user',
} as const;

export const AUTH_EVENTS = {
  UNAUTHORIZED: 'auth:unauthorized',
  TOKEN_EXPIRED: 'auth:token_expired',
} as const;

const api: AxiosInstance = axios.create({
  baseURL: BASE_URL,
  timeout: 30000,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
});

api.interceptors.request.use(
  (config: InternalAxiosRequestConfig) => {
    try {
      const rawToken = localStorage.getItem(STORAGE_KEYS.TOKEN);
      const token = rawToken?.replace(/^["'](.+)["']$/, '$1');
      if (token && token !== 'undefined') {
        config.headers.Authorization = `Bearer ${token}`;
      }
    } catch (e) {
      console.error("Auth Error:", e);
    }
    return config;
  },
  (error: AxiosError) => Promise.reject(error)
);

export const apiService = {
  getReports: async () => {
    const res = await api.get('/reports');
    return res.data;
  },

  verifyReport: async (id: number, status: string) => {
    const res = await api.put(`/reports/${id}/verify`, { status });
    return res.data;
  },

  getMembers: async () => {
    const res = await api.get('/members');
    return res.data;
  },

  createMember: async (data: { name: string; role: string; phone?: string; email?: string }) => {
    const res = await api.post('/members', data);
    return res.data;
  },

  updateMember: async (id: string | number, data: { name?: string; role?: string; phone?: string; email?: string; active?: boolean }) => {
    const res = await api.put(`/members/${id}`, data);
    return res.data;
  },

  deleteMember: async (id: string | number) => {
    const res = await api.delete(`/members/${id}`);
    return res.data;
  },
};

export default api;