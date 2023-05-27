<template>
    <div>
        <div class="content-header px-4">
            <h1>Баннеры</h1>
            <router-link :to="{name: 'BannerMaster'}" class="btn btn-primary">Добавить</router-link>
        </div>

        <div v-if="views.loading" class="p-4">
            <Loader />
        </div>

        <div v-if="!views.loading" class="content p-4">
            <table v-if="banners.length" class="table align-middle">
                <tbody>
                    <tr v-for="banner in banners">
                        <td>{{ banner.name }}</td>
                        <td class="text-end">
                            <router-link :to="{ name: 'BannerMaster', params: {id: banner.id} }" class="btn btn-sm btn-outline-primary">Правка</router-link>
                        </td>
                    </tr>
                </tbody>
            </table>

            <p v-else>Баннеров нет.</p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            banners: [],

            views: {
                loading: true,
            }
        }
    },
    created() {
        this.loadBanners()
    },
    methods: {
        loadBanners() {
            axios.get('/api/admin/banners')
            .then(response => {
                this.banners = response.data

                this.views.loading = false
            })
        },
    },
}
</script>