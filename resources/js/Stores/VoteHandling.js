import { defineStore } from 'pinia';

export const useVoteStore = defineStore('voteStore', {
    state: () => {
        return {
            user: null,
            errors: {},
        };
    },
    actions: {
        async votesubmit(vote,type,route) {
            const token = localStorage.getItem('token');
            console.log(vote);
            
            const res = await fetch(`/api/${type}/${route}/vote`, {
                method: 'post',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: `{"vote" : ${vote}}`,
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






    }
})