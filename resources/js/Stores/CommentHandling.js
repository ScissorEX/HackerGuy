import { defineStore } from 'pinia';

export const useCommentStore = defineStore('commentStore', {
    state: () => {
        return {
            user: null,
            errors: {},
        };
    },
    actions: {
        async commentsubmit(post,content) {
            const token = localStorage.getItem('token');

            const res = await fetch(`/api/posts/${post}/comments`, {
                method: 'post',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify(content),
            });
            
            if (!res.ok) {
                console.error('Response status:', res.status);
                const text = await res.text();
                console.error('Response body:', text);
                throw new Error(`HTTP error! status: ${res.status}`);
            }
            const data = await res.json();
            console.log(data);
            
            return data;
        },
        
            
    }
})