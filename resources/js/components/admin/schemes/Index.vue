<template>
    <div>
        <div class="content-header px-4">
            <h1>Схемы</h1>
            <router-link :to="{name: 'SchemeMaster'}" class="btn btn-primary">Добавить</router-link>
        </div>

        <div v-if="views.loading" class="p-4">
            <Loader />
        </div>

        <div v-if="!views.loading" class="content p-4">
            <table v-if="schemes.length" class="table align-middle">
                <tbody>
                    <tr v-for="scheme in schemes">
                        <td>{{ scheme.name }}</td>
                        <td class="text-end">
                            <router-link :to="{ name: 'SchemeMaster', params: {id: scheme.id} }" class="btn btn-sm btn-outline-primary">Правка</router-link>
                        </td>
                    </tr>
                </tbody>
            </table>

            <p v-else>Схем нет.</p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            schemes: [],

            views: {
                loading: true,
            }
        }
    },
    created() {
        this.loadSchemes()
    },
    methods: {
        loadSchemes() {
            axios.get('/api/admin/schemes')
            .then(response => {
                this.schemes = response.data

                this.views.loading = false
            })
        },
    },
}
</script>