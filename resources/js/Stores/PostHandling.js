import { defineStore } from "pinia";

export const usePostStore = defineStore("postStore", {
    state: () => {
        return {
            user: null,
            errors: {},
        };
    },
    actions: {
        async getListPosts() {
            const res = await fetch("/api/posts");
            const json = await res.json();
            const data = json.data;
            return data;
        },
        async getPost(post) {
            const token = localStorage.getItem("token");

            const res = await fetch(`/api/posts/${post}`, {
                headers: { Authorization: `Bearer ${token}` },
            });
            const data = await res.json();

            return data;
        },
        async postsubmit(formdata) {
            const token = localStorage.getItem("token");

            const res = await fetch("/api/posts", {
                method: "post",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    Authorization: `Bearer ${token}`,
                },
                body: JSON.stringify(formdata),
            });

            if (!res.ok) {
                console.error("Response status:", res.status);
                const text = await res.text();
                console.error("Response body:", text);
                throw new Error(`HTTP error! status: ${res.status}`);
            }

            const data = await res.json();
            return data;
        },
        async postupdate(formdata,id) {
            const token = localStorage.getItem("token");
            
            const res = await fetch(`/api/posts/${id}`, {
                method: "patch",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    Authorization: `Bearer ${token}`,
                },
                body: JSON.stringify(formdata),
            });

            if (!res.ok) {
                console.error("Response status:", res.status);
                const text = await res.text();
                console.error("Response body:", text);
                throw new Error(`HTTP error! status: ${res.status}`);
            }

            const data = await res.json();
            return data;
        },
        async postdelete(id) {
            const token = localStorage.getItem("token");

            const res = await fetch(`/api/posts/${id}`, {
                method: "delete",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    Authorization: `Bearer ${token}`,
                }
            });

            if (!res.ok) {
                console.error("Response status:", res.status);
                const text = await res.text();
                console.error("Response body:", text);
                throw new Error(`HTTP error! status: ${res.status}`);
            }

            const data = await res.json();
            return data;
        },
    },
});
