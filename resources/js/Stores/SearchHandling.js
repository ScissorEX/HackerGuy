import { defineStore } from "pinia";

export const useSearchStore = defineStore("searchStore", {
    state: () => {
        return {
            errors: {},
            searchres: [],
        };
    },
    actions: {
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
        async searchpost(search) {
            const res = await fetch(`/api/search?search=${search}`);
            const data = await res.json();
            this.searchres = data
            return data;
        },
    },
});
