import axios from 'axios';
import { defineStore } from 'pinia';

/**
 * @typedef {Object} User
 * @property {string} role
 * @property {string} name
 */

/**
 * @typedef {Object} Company
 * @property {string} nombre
 */

/**
 * @typedef {Object} LoginResponse
 * @property {string} token
 * @property {User} user
 * @property {Company} company
 */

/**
 * @typedef {Object} ErrorResponse
 * @property {number} status
 * @property {Object} errors
 */

export const useAuthStore = defineStore('auth', {
    state: () => ({ 
        /** @type {User|null} */
        authUser: null, 
        /** @type {string|null} */
        authToken: null, 
        /** @type {Company|null} */
        authCompany: null,
        /** @type {string|null} */
        returnUrl: null
    }),
    getters: {
        /** @returns {User|null} */
        user: (state) => state.authUser,
        /** @returns {Company|null} */
        company: (state) => state.authCompany,
        /** @returns {string|null} */
        token: (state) => state.authToken
    },
    actions: {
        /**
         * @param {Object} form
         * @returns {Promise<ErrorResponse|void>}
         */
        async login(form) {
            try {
                /** @type {import('axios').AxiosResponse<LoginResponse>} */
                const response = await axios.post('/login', form);
                this.authToken = response.data.token;
                this.authUser = response.data.user;
                this.authCompany = response.data.company;
                this.router.push('/');
            } catch (error) {
                const status = error.response.status;
                const errors = error.response.data.errors;
                return { status, errors };
            }
        },
        /**
         * @param {Object} form
         * @returns {Promise<ErrorResponse|void>}
         */
        async register(form) {
            try {
                /** @type {import('axios').AxiosResponse<LoginResponse>} */
                const response = await axios.post('/register', form);
                this.authToken = response.data.token;
                this.authUser = response.data.user;
                this.router.push('/');
            } catch (error) {
                const status = error.response.status;
                const errors = error.response.data.errors;
                return { status, errors };
            }
        },
        /** @returns {Promise<void>} */
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
});