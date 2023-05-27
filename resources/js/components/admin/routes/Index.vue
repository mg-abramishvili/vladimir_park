<template>
    <div>
        <div class="content-header px-4">
            <div class="d-flex">
                <h1 class="me-2">Маршруты</h1>

                <select v-if="kiosks.length" v-model="selected.kiosk" @change="changeKiosk()" class="form-select">
                    <option v-for="kiosk in kiosks" :value="kiosk.id">{{ kiosk.name }}</option>
                </select>
            </div>
            <router-link :to="{name: 'RouteMaster'}" class="btn btn-primary">Добавить</router-link>
        </div>
        
        <div v-if="views.loading" class="p-4">
            <Loader />
        </div>

        <div v-if="!views.loading" class="content p-4">
            <table v-if="routes.length" class="table align-middle">
                <tbody>
                    <tr v-for="route in routes">
                        <td>{{ route.name }}</td>
                        <td class="text-end">
                            <router-link :to="{ name: 'RouteMaster', params: {id: route.id} }" class="btn btn-sm btn-outline-primary">Правка</router-link>
                        </td>
                    </tr>
                </tbody>
            </table>

            <p v-else>Маршуртов нет.</p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            routes: [],
            kiosks: [],

            selected: {
                kiosk: null,
            },

            views: {
                loading: true,
            }
        }
    },
    created() {
        this.loadKiosks()
        this.loadRoutes()
    },
    methods: {
        loadKiosks() {
            axios.get(`/api/admin/kiosks`)
            .then(response => {
                this.kiosks = response.data

                this.selected.kiosk = this.$route.params.kiosk
            })
        },
        loadRoutes() {
            axios.get(`/api/admin/routes/${this.$route.params.kiosk}`)
            .then(response => {
                this.routes = response.data

                this.views.loading = false
            })
        },
        changeKiosk() {
            this.$router.push({ name: 'Routes', params: {kiosk: this.selected.kiosk} })
            
            setTimeout(() => {
                this.loadRoutes()
            }, 100)
        },
    },
}
</script>