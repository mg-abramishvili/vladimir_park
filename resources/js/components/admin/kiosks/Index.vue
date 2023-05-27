<template>
    <div>
        <div class="content-header px-4">
            <h1>Киоски</h1>
            <router-link :to="{name: 'KioskMaster'}" v-if="!kiosks.length" class="btn btn-primary">Добавить</router-link>
        </div>

        <div v-if="views.loading" class="p-4">
            <Loader />
        </div>

        <div v-if="!views.loading" class="content p-4">
            <table v-if="kiosks.length" class="table align-middle">
                <tbody>
                    <tr v-for="kiosk in kiosks">
                        <td>{{ kiosk.name }}</td>
                        <td class="text-end">
                            <router-link :to="{ name: 'KioskMaster', params: {id: kiosk.id} }" class="btn btn-sm btn-outline-primary">Правка</router-link>
                        </td>
                    </tr>
                </tbody>
            </table>

            <p v-else>Киосков нет.</p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            kiosks: [],

            views: {
                loading: true,
            }
        }
    },
    created() {
        this.loadKiosks()
    },
    methods: {
        loadKiosks() {
            axios.get('/api/admin/kiosks')
            .then(response => {
                this.kiosks = response.data

                this.views.loading = false
            })
        },
    },
}
</script>