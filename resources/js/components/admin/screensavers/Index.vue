<template>
    <div>
        <div class="content-header px-4">
            <h1>Заставки</h1>
            <router-link :to="{name: 'ScreensaverMaster'}" class="btn btn-primary">Добавить</router-link>
        </div>

        <div v-if="views.loading" class="p-4">
            <Loader />
        </div>

        <div v-if="!views.loading" class="content p-4">
            <table v-if="screensavers.length" class="table align-middle">
                <tbody>
                    <tr v-for="screensaver in screensavers">
                        <td>{{ screensaver.name }}</td>
                        <td class="text-end">
                            <router-link :to="{ name: 'ScreensaverMaster', params: {id: screensaver.id} }" class="btn btn-sm btn-outline-primary">Правка</router-link>
                        </td>
                    </tr>
                </tbody>
            </table>

            <p v-else>Заставок нет.</p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            screensavers: [],

            views: {
                loading: true,
            }
        }
    },
    created() {
        this.loadScreensavers()
    },
    methods: {
        loadScreensavers() {
            axios.get('/api/admin/screensavers')
            .then(response => {
                this.screensavers = response.data

                this.views.loading = false
            })
        },
    },
}
</script>