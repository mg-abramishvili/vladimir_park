<template>
    <div>
        <div class="content-header px-4">
            <h1>Афиша</h1>
            <router-link :to="{name: 'EventMaster'}" class="btn btn-primary">Добавить</router-link>
        </div>

        <div v-if="views.loading" class="p-4">
            <Loader />
        </div>

        <div v-if="!views.loading" class="content p-4">
            <table v-if="events.length" class="table align-middle">
                <tbody>
                    <tr v-for="event in events">
                        <td>{{ event.name }}</td>
                        <td>{{ $filters.date(event.date) }}</td>
                        <td class="text-end">
                            <router-link :to="{ name: 'EventMaster', params: {id: event.id} }" class="btn btn-sm btn-outline-primary">Правка</router-link>
                        </td>
                    </tr>
                </tbody>
            </table>

            <p v-else>Афиша пуста.</p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            events: [],

            views: {
                loading: true,
            }
        }
    },
    created() {
        this.loadEvents()
    },
    methods: {
        loadEvents() {
            axios.get('/api/admin/events')
            .then(response => {
                this.events = response.data

                this.views.loading = false
            })
        },
    },
}
</script>