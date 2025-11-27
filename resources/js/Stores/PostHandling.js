import { defineStore } from 'pinia';

export const usePostStore = defineStore('postStore', {
    state: () => {
        return {
            user: null,
            errors: {},
        };
    },
    actions: {
        async postsubmit(formdata) {
            const token = localStorage.getItem('token');

            const res = await fetch('/api/posts', {
            method: 'post',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify(formdata),
});

            if (!res.ok) {
            console.error('Response status:', res.status);
            const text = await res.text();
            console.error('Response body:', text);
            throw new Error(`HTTP error! status: ${res.status}`);
            }

        const data = await res.json();
        return data;
        },

    },
});
