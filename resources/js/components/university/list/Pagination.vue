<template>
    <div>
        <template v-if="pagination.page > 1">
            <button @click="setPage(1)"><<<</button>
            <button @click="setPage(pagination.page-1)"><</button>
        </template>

        <button disabled>{{ pagination.page }}</button>

        <template v-if="pagination.page != pagination.lastPage">
            <button @click="setPage(pagination.page+1)">></button>
            <button @click="setPage(pagination.lastPage)">>>></button>
        </template>
    </div>
</template>

<script>
export default {
    name: "UniversityListPagination",

    props: {
        pagination: {
            type: Object
        }
    },

    methods: {
        setPage(page) {
            this.pagination.page = page
            this.$emit('page-changed')
        }
    }
}
</script>

<style scoped>

</style>
