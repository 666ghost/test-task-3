<template>
    <div>
        <h3 v-if="loading">Loading...</h3>
        <template v-else>
            <input type="text" v-model="searchText">
            <button @click="getUniversities">Search</button>
            <table class="bordered-table">
                <tr>
                    <th>Name</th>
                    <th>Country</th>
                    <th>Domains</th>
                    <th>Web Pages</th>
                    <th>State province</th>
                    <th>Alpha Two Code</th>
                </tr>
                <tr v-for="university in universities">
                    <td>{{ university.name }}</td>
                    <td>{{ university.country }}</td>
                    <td>{{ university.domains.join(', ') }}</td>
                    <td>{{ university.web_pages.join(', ') }}</td>
                    <td>{{ university['state-province'] }}</td>
                    <td>{{ university.alpha_two_code }}</td>

                </tr>
            </table>

            <university-list-pagination :pagination="pagination"
                                        @page-changed="getUniversities"></university-list-pagination>
        </template>
    </div>
</template>

<script>
import Pagination from "./list/Pagination";

export default {
    name: "UniversityList",

    components: {
        'university-list-pagination': Pagination
    },

    data() {
        return {
            universities: [],
            loading: false,
            pagination: {
                page: 1,
                lastPage: 1,
            },
            searchText: '',
            updateCacheTasks: []
        }
    },

    mounted() {
        this.getUniversities()
    },

    methods: {
        getUniversities() {
            this.loading = true
            axios.get('api/university/find?search_text=' + this.searchText + '&page=' + this.pagination.page).then((response) => {
                this.universities = response.data.data
                this.pagination.lastPage = response.data.last_page
                this.loading = false
                this.scheduleUpdatingUniversities()

            }).catch((e) => {
                this.loading = false
                console.log(e)
            })
        },

        scheduleUpdatingUniversities() {
            this.clearAllUpdateTasks()
            this.universities.forEach(university => this.scheduleUpdate(university))
        },

        scheduleUpdate(university) {
            const executeAfter = university.expires_at * 1000 - new Date().getTime() + 3000
            this.updateCacheTasks.push(setTimeout(() => this.updateCache(university.id), executeAfter))
        },

        updateCache(id) {

            axios.post('api/university/update-cache/' + id).then((response) => {
                let universityIndex = this.universities.findIndex(x => x.id === id)
                this.universities[universityIndex] = response.data;

                this.scheduleUpdate(this.universities[universityIndex])
            })
        },

        clearAllUpdateTasks() {
            this.updateCacheTasks.forEach(id => clearTimeout(id))
        },
    },
}
</script>

<style scoped>
.bordered-table > tr th, td {
    border: 1px solid #1a202c;
}
</style>
