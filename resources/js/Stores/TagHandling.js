import { defineStore } from "pinia";

export const useTagStore = defineStore("tagStore", {
    state: () => {
        return {
            user: null,
            errors: {},
        };
    },
    actions: {
        //Tags handling together with Category handling, I'm lazy.

        async listcategories() {
            const res = await fetch("/api/category");
            const json = await res.json();
            const data = json.data;
            return data;
        },
        async getcategory(id) {
            const res = await fetch(`/api/category/${id}`);
            const data = await res.json();

            return data;
        },
    },
});
