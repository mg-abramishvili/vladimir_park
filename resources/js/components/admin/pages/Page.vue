<template>
    <div>
        <div class="content-header px-4">
            <h1>
                <router-link v-if="page.parent_id" :to="{name: 'Page', params: {id: page.parent_id} }" class="btn btn-back">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                    </svg>
                </router-link>
                <router-link v-else :to="{name: 'Pages'}" class="btn btn-back">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                    </svg>
                </router-link>

                {{ page.name }}
            </h1>

            <div>
                <router-link :to="{name: 'PageMaster', query: {type: 'page', from: page.id} }" class="btn btn-primary">Создать страницу</router-link>
                <router-link :to="{name: 'PageMaster', query: {type: 'folder', from: page.id} }" class="btn btn-outline-primary ms-2">Создать папку</router-link>
            </div>
        </div>

        <div v-if="views.loading" class="p-4">
            <Loader />
        </div>

        <div v-if="!views.loading" class="content p-4">
            <draggable v-if="page.children.length"
                :list="page.children"
                :disabled="false"
                item-key="id"
                ghost-class="ghost"
                :move="checkMove" >
                <template #item="{ element }">
                    <div class="page-list-item">
                        <div @click="goToPage(element)" class="w-50">
                            <div class="page-list-item-name">    
                                <div v-if="!element.is_folder" class="page-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-text" viewBox="0 0 16 16">
                                        <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/>
                                        <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                                    </svg>
                                </div>
                                <div v-if="element.is_folder" class="page-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder2" viewBox="0 0 16 16">
                                        <path d="M1 3.5A1.5 1.5 0 0 1 2.5 2h2.764c.958 0 1.76.56 2.311 1.184C7.985 3.648 8.48 4 9 4h4.5A1.5 1.5 0 0 1 15 5.5v7a1.5 1.5 0 0 1-1.5 1.5h-11A1.5 1.5 0 0 1 1 12.5v-9zM2.5 3a.5.5 0 0 0-.5.5V6h12v-.5a.5.5 0 0 0-.5-.5H9c-.964 0-1.71-.629-2.174-1.154C6.374 3.334 5.82 3 5.264 3H2.5zM14 7H2v5.5a.5.5 0 0 0 .5.5h11a.5.5 0 0 0 .5-.5V7z"/>
                                    </svg>
                                </div>
                                {{ element.name }}
                            </div>
                        </div>
                        <div class="w-25">
                            <template v-if="!element.is_folder">{{ $filters.datetime(element.updated_at) }}</template>
                        </div>
                        <div class="w-25 text-end">
                            <router-link v-if="!element.is_folder" :to="{ name: 'PageMaster', params: {id: element.id} }" class="btn btn-sm btn-outline-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                </svg>
                            </router-link>
                            <router-link v-if="element.is_folder" :to="{ name: 'PageMaster', params: {id: element.id} }" class="btn btn-sm btn-outline-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                </svg>
                            </router-link>
                        </div>
                    </div>
                </template>
            </draggable>

            <p v-else>Пусто.</p>

            <button v-if="views.reorderButton" @click="reorderPages()" class="btn btn-sm btn-outline-danger mt-4">Сохранить порядок</button>
        </div>
    </div>
</template>

<script>
import draggable from "vuedraggable"

export default {
    data() {
        return {
            page: {},

            views: {
                loading: true,
                reorderButton: false,
            }
        }
    },
    created() {
        this.loadPages()
    },
    methods: {
        loadPages() {
            axios.get(`/api/admin/page/${this.$route.params.id}`)
            .then(response => {
                this.page = response.data

                this.views.loading = false
            })
        },
        goToPage(page) {
            if(page.is_folder) {
                this.$router.push({name: 'Page', params: {id: page.id} })
            }
        },
        checkMove: function(e) {
            this.views.reorderButton = true
        },
        reorderPages() {
            axios.post('/api/admin/pages-reorder', {
                pages: this.page.children.map(function(page, index) {{
                    return {
                        id: page.id,
                        order: index,
                    } 
                }})
            })
            .then(response => {
                this.views.reorderButton = false
            })
        },
    },
    components: {
        draggable
    }
}
</script>
