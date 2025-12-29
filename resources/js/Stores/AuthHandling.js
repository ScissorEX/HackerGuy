import { defineStore } from 'pinia';

export const useAuthStore = defineStore('authStore', {
    state: () => {
        return {
            user: null,
            errors: {},
        };
    },
    actions: {
        async getUser() {
            if (localStorage.getItem('token')) {
                const res = await fetch('/api/user', {
                    headers: {
                        authorization: `Bearer ${localStorage.getItem('token')}`,
                    },
                });
                const data = await res.json();
                if (res.ok) {
                    this.user = data;
                }
            }
        },
        async formsubmit(route, formdata) {
            const token = document.querySelector('meta[name="csrf"]').content;

            const res = await fetch(`/api/${route}`, {
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formdata),
            });

            const data = await res.json();
            if (data.errors) {
                this.errors = data.errors;
            } else {
                this.errors = {};
                localStorage.setItem('token', data.token);
                this.user = data.user;
                this.router.push({ name: 'home' });
            }
        },

        async logout() {
            const res = await fetch('/api/logout', {
                method: 'post',
                headers: {
                    authorization: `Bearer ${localStorage.getItem('token')}`,
                },
            });

            const data = await res.json();

            if (res.ok) {
                this.user = null;
                this.errors = {};
                localStorage.removeItem('token');
                router.push({ name: 'home' });
            }
        },
    },
});
