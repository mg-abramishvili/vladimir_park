<template>
    <div>
        <div class="content-header px-4">
            <h1>
                <router-link :to="{name: 'Pages'}" class="btn btn-back">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                    </svg>
                </router-link>

                <template v-if="$route.params.id">
                    {{ page.name }}
                </template>
                <template v-else>
                    Новая страница
                </template>
            </h1>
        </div>

        <div v-if="views.loading" class="p-4">
            <Loader />
        </div>

        <div v-if="!views.loading" class="content p-4">
            <div class="mb-4">
                <label class="form-label">Название страницы</label>
                <input v-model="name" type="text" class="form-control">
            </div>

            <div class="mb-4">
                <label class="form-label d-block">Иконка страницы</label>
                <img v-if="selected.icon" @click="views.icons = true" :src="selected.icon.image" alt="" style="width: auto; height: auto; max-width: 500px; max-height: 100px; border-radius: 5px">
                <button v-else @click="views.icons = true" class="btn btn-outline-secondary">Задать</button>
                
                <Icons v-if="views.icons" :icons="icons" />
            </div>            

            <div v-if="!is_folder" class="page-editor">
                <div class="toolbox">
                    <ul>
                        <li>
                            <button @click="addBlock('text')" class="btn btn-outline-primary">+ Текст</button>
                        </li>
                        <li>
                            <button @click="addBlock('image')" class="btn btn-outline-primary">+ Картинка</button>
                        </li>
                        <li>
                            <button @click="addBlock('image_slider')" class="btn btn-outline-primary">+ Фотослайдер</button>
                        </li>
                        <li>
                            <button @click="addBlock('video')" class="btn btn-outline-primary">+ Видео</button>
                        </li>
                        <li>
                            <button @click="addBlock('audio')" class="btn btn-outline-primary">+ Аудио</button>
                        </li>
                        <li>
                            <button @click="addBlock('pdf')" class="btn btn-outline-primary">+ PDF</button>
                        </li>
                        <li>
                            <button @click="addBlock('excel')" class="btn btn-outline-primary">+ Excel</button>
                        </li>
                        <li>
                            <button @click="addBlock('iframe')" class="btn btn-outline-primary">+ iFrame</button>
                        </li>
                        <li>
                            <button @click="addBlock('routes')" class="btn btn-outline-primary">+ Маршруты</button>
                        </li>
                    </ul>
                </div>

                <div class="page-area">
                    <draggable
                        :list="blocks"
                        :disabled="false"
                        item-key="id"
                        ghost-class="ghost"
                        :move="checkMove" >

                        <template #item="{ element }">
                            <div v-if="element.type == 'text'" class="block-area">
                                <div @click="editBlock(element)" v-html="element.content"></div>
                                <button @click="removeBlock(element.id)" class="btn btn-secondary">&times;</button>
                            </div>

                            <div v-else-if="element.type == 'image'" class="block-area">
                                <div @click="editBlock(element)">
                                    <img v-if="element.content" :src="element.content" alt="">
                                    <img v-else src="/img/image-placeholder.png" alt="">
                                </div>
                                <button @click="removeBlock(element.id)" class="btn btn-secondary">&times;</button>
                            </div>

                            <div v-else-if="element.type == 'image_slider'" class="block-area block-area-image-slider">
                                <div @click="editBlock(element)">
                                    <div v-if="element.content" class="d-flex">
                                        <img v-for="imageItem in element.content.split(',')" :src="imageItem" alt="">
                                    </div>
                                    <img v-else src="/img/image-placeholder.png" alt="">
                                </div>
                                <button @click="removeBlock(element.id)" class="btn btn-secondary">&times;</button>
                            </div>

                            <div v-else-if="element.type == 'video'" class="block-area">
                                <div @click="editBlock(element)">
                                    <video v-if="element.content">
                                        <source :src="element.content" type="video/mp4" />
                                    </video>
                                    <img v-else src="/img/video-placeholder.png" alt="">
                                </div>
                                <button @click="removeBlock(element.id)" class="btn btn-secondary">&times;</button>
                            </div>

                            <div v-else-if="element.type == 'audio'" class="block-area">
                                <div @click="editBlock(element)">
                                    <img src="/img/audio-placeholder.png" alt="">
                                </div>
                                <button @click="removeBlock(element.id)" class="btn btn-secondary">&times;</button>
                            </div>

                            <div v-else-if="element.type == 'pdf'" class="block-area">
                                <div @click="editBlock(element)">
                                    <template v-if="element.content" >
                                        <iframe :src="'/pdfjs/web/viewer-admin.html?file=' + element.content" height="100%" width="100%" style="border: none;"></iframe>
                                        <div class="iframe-overlay"></div>
                                    </template>
                                    <img v-else src="/img/pdf-placeholder.png" alt="">
                                </div>
                                <button @click="removeBlock(element.id)" class="btn btn-secondary">&times;</button>
                            </div>

                            <div v-else-if="element.type == 'excel'" class="block-area">
                                <div @click="editBlock(element)">
                                    <template v-if="element.content">
                                        <div :id="XlsxTable(element)" style="text-align: center;"></div>
                                        <div class="table-overlay"></div>
                                    </template>
                                    <img v-else src="/img/excel-placeholder.png" alt="">
                                </div>
                                <button @click="removeBlock(element.id)" class="btn btn-secondary">&times;</button>
                            </div>

                            <div v-else-if="element.type == 'iframe'" class="block-area">
                                <div>
                                    <p @click="editBlock(element)" v-if="element.content" class="m-0">{{ element.content }}</p>
                                    <p @click="editBlock(element)" v-else class="m-0">Укажите адрес для iFrame</p>
                                </div>
                                <button @click="removeBlock(element.id)" class="btn btn-secondary">&times;</button>
                            </div>

                            <div v-else-if="element.type == 'routes'" class="block-area">
                                <div>
                                    <p class="m-0">Блок Маршруты</p>
                                </div>
                                <button @click="removeBlock(element.id)" class="btn btn-secondary">&times;</button>
                            </div>

                            <div v-else-if="element.type == 'events'" class="block-area">
                                <div>
                                    <p class="m-0">Блок Афиша</p>
                                </div>
                                <button @click="removeBlock(element.id)" class="btn btn-secondary">&times;</button>
                            </div>
                        </template>
                    </draggable>
                </div>
            </div>

            <div class="mt-4">
                <button @click="save()" :disabled="!views.saveButton" class="btn btn-primary">Сохранить</button>
                <button @click="del()" v-if="$route.params.id" class="btn btn-outline-danger ms-2">Удалить</button>
            </div>
        </div>

        <BlockMaster v-if="selected.block" :block="selected.block" />
        <div v-if="selected.block || views.icons" class="modal-backdrop fade show"></div>
    </div>
</template>

<script>
import draggable from "vuedraggable"
import { read, utils } from 'xlsx'

import BlockMaster from './blocks/Master.vue'
import Icons from './icons/Index.vue'

export default {
    props: ['query'],
    data() {
        return {
            page: {},

            icons: [],
            blocks: [],

            name: '',
            parent_id: '',
            is_folder: false,

            selected: {
                block: '',
                icon: '',
                parent: '',
                language: '',
            },

            views: {
                loading: true,
                saveButton: true,
                icons: false,
            }
        }
    },
    watch: {
        blocks: {
            handler() {
                setTimeout(() => {
                    this.blocks = this.blocks.map(function(block, index) {
                        {
                            return {
                                id: block.id,
                                type: block.type,
                                content: block.content,
                                order: index
                            } 
                        }
                    })
                }, 1000)
            },
            deep: true,
        }
    },
    created() {
        this.loadIcons()

        if(this.query.type && this.query.type == 'folder') {
            this.is_folder = true
        }

        if(this.query.from) {
            this.parent_id = this.query.from
        }
    },
    methods: {
        loadIcons() {
            axios.get('/api/admin/icons')
            .then(response => {
                this.icons = response.data

                if(this.$route.params.id) {
                    this.loadPage()
                } else {
                    this.views.loading = false
                }
            })
        },
        loadPage() {
            axios.get(`/api/admin/page/${this.$route.params.id}`)
            .then(response => {
                this.page = response.data

                this.name = response.data.name
                this.blocks = response.data.blocks
                this.parent_id = response.data.parent_id
                this.is_folder = response.data.is_folder
                this.selected.icon = this.icons.find(icon => icon.id == response.data.icon_id)

                this.views.loading = false
            })
        },
        addBlock(blockType) {
            let content = ''

            if(blockType == 'text') {
                content = "<p>Текст...</p>"
            }

            if(blockType == 'routes') {
                if(this.blocks.length) {
                    return this.$swal({
                        text: 'Блок Маршруты нельзя совмещать с другими блоками',
                        icon: 'error',
                    })
                }

                content = "routes"
            }

            if(blockType == 'events') {
                if(this.blocks.length) {
                    return this.$swal({
                        text: 'Блок Афиша нельзя совмещать с другими блоками',
                        icon: 'error',
                    })
                }

                content = "events"
            }

            let newBlock = {
                id: 'temp_' + blockType + '_' + Math.floor((Math.random()*100) + 1) + '_' + Math.floor((Math.random()*100) + 1),
                type: blockType,
                content: content,
                order: 99
            }

            if(this.blocks.find(block => block.type == 'routes')) {
                return this.$swal({
                    text: 'Блок Маршруты нельзя совмещать с другими блоками',
                    icon: 'error',
                })
            }

            if(this.blocks.find(block => block.type == 'events')) {
                return this.$swal({
                    text: 'Блок Афиша нельзя совмещать с другими блоками',
                    icon: 'error',
                })
            }

            this.blocks.push(newBlock)
        },
        removeBlock(id) {
            this.blocks = this.blocks.filter(block => block.id != id)
        },
        editBlock(block) {
            this.selected.block = block
        },
        checkMove: function(e) {
            console.log(e)
        },
        XlsxTable(element) {
            axios.get(element.content, { responseType: 'arraybuffer' })
            .then(response => {
                let wb = read(response.data)
                
                let div = document.getElementById(element.id)

                if(!div.innerHTML) {
                    document.getElementById(element.id).innerHTML = utils.sheet_to_html(wb.Sheets[wb.SheetNames[0]], { header: '', footer: '' })
                }
            })

            return element.id
        },
        save() {
            if(!this.name) {
                return this.$swal({
                    text: 'Укажите название',
                    icon: 'error',
                })
            }
            if(!this.selected.icon) {
                return this.$swal({
                    text: 'Выберите инконку для страницы',
                    icon: 'error',
                })
            }
            if(!this.is_folder && !this.blocks.length) {
                return this.$swal({
                    text: 'Страница не может быть пуста, добавить блоки с контентом',
                    icon: 'error',
                })
            }

            this.views.saveButton = false

            if(this.$route.params.id) {
                axios.put(`/api/admin/page/${this.$route.params.id}/update`, {
                    name: this.name,
                    blocks: this.blocks,
                    icon_id: this.selected.icon.id,
                    is_folder: this.is_folder,
                    parent_id: this.parent_id,
                })
                .then(response => {
                    this.views.saveButton = true

                    if(this.query.from) {
                        this.$router.push({ name: 'Page', params: {id: this.query.from } })
                    } else {
                        this.$router.push({ name: 'Pages' })
                    }
                })
                .catch(errors => {
                    this.views.saveButton = true
                    
                    return this.$swal({
                        text: 'Ошибка',
                        icon: 'error',
                    })
                })
            }

            if(!this.$route.params.id) {
                axios.post(`/api/admin/pages`, {
                    name: this.name,
                    blocks: this.blocks,
                    icon_id: this.selected.icon.id,
                    is_folder: this.is_folder,
                    parent_id: this.parent_id,
                })
                .then(response => {
                    this.views.saveButton = true
    
                    if(this.query.from) {
                        this.$router.push({ name: 'Page', params: {id: this.query.from } })
                    } else {
                        this.$router.push({ name: 'Pages' })
                    }
                })
                .catch(errors => {
                    this.views.saveButton = true
                    
                    return this.$swal({
                        text: 'Ошибка',
                        icon: 'error',
                    })
                })
            }
        },
        del() {
            if(confirm('Точно удалить страницу?')) {
                axios.delete(`/api/admin/page/${this.$route.params.id}/delete`)
                .then(response => {
                    this.$router.push({ name: 'Pages' })
                })
                .catch(errors => {
                    return this.$swal({
                        text: errors.response.data,
                        icon: 'error',
                    })
                })
            }
        },
    },
    components: {
        draggable,
        BlockMaster,
        Icons,
    }
}
</script>