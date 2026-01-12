import { defineStore } from "pinia";

export const useUserStore = defineStore("userStore", {
    state: () => {
        return {
            errors: {},
        };
    },
    actions: {
        async getuserdata(handle) {
            if (localStorage.getItem("token")) {
                const res = await fetch(`/api/thisuser/${handle}`, {
                    headers: {
                        authorization: `Bearer ${localStorage.getItem("token")}`,
                    },
                });
                if (!res.ok) {
                    console.error("Response status:", res.status);
                    const text = await res.text();
                    console.error("Response body:", text);
                    throw new Error(`HTTP error! status: ${res.status}`);
                }
                const data = await res.json();
                return data;
            }
        },
    },
});
