import axios from 'axios';
import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
    state: () => ({ authUser: null, authToken: null, authCompany: null }),
    getters: {
        user: (state) => state.authUser,
        company: (state) => state.authCompany,
        token: (state) => state.authToken
    },
    actions: {
        async login(form) {
            try {
                const response = await axios.post('/login', form);
                this.authToken = response.data.token;
                this.authUser = response.data.user;
                this.authCompany = response.data.company;
                this.router.push('/');
            } catch (errors) {
                const status = errors.response.status;
                const list_errors = errors.response.data.errors;
                return { status, list_errors };
            }
        },
        async register(form) {
            try {
                const response = await axios.post('/register', form);
                this.authToken = response.data.token;
                this.authUser = response.data.user;
                this.router.push('/');
            } catch (errors) {
                const status = errors.response.status;
                const list_errors = errors.response.data.errors;
                return { status, list_errors };
            }
        },
        async logout() {
            const headers = { Authorization: `Bearer ${this.authToken}` };
            await axios.post('/logout', null, { headers });
            this.authToken = null;
            this.authUser = null;
            this.authCompany = null;
            this.router.push('/login');
        },
    },
    persist: true
})