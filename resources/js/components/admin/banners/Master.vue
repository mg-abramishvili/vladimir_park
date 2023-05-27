<template>
    <div>
        <div class="content-header px-4">
            <h1>
                <router-link :to="{name: 'Banners'}" class="btn btn-back">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                    </svg>
                </router-link>

                <template v-if="$route.params.id">
                    {{ banner.name }}
                </template>
                <template v-else>
                    Новый баннер
                </template>
            </h1>
        </div>

        <div v-if="views.loading" class="p-4">
            <Loader />
        </div>

        <div v-if="!views.loading" class="content p-4">
            <div class="mb-4">
                <label class="form-label">Название</label>
                <input v-model="name" type="text" class="form-control">
            </div>

            <div class="mb-4">
                <select v-model="selected.type" class="form-select" disabled>
                    <option value="image">Изображение</option>
                    <option value="video">Видео</option>
                </select>
            </div>

            <div v-if="selected.type == 'image'" class="mb-4">
                <label class="form-label">Изображение</label>
                <file-pond
                    name="banner_image"
                    ref="banner_image"
                    label-idle="Выбрать файл"
                    v-bind:allow-multiple="false"
                    v-bind:allow-reorder="false"
                    accepted-file-types="image/jpeg, image/png"
                    :server="server"
                    v-bind:files="filepond_content_edit"
                />
            </div>

            <div v-if="selected.type == 'video'" class="mb-4">
                <label class="form-label">Видео</label>
                <file-pond
                    name="banner_video"
                    ref="banner_video"
                    label-idle="Выбрать файл"
                    v-bind:allow-multiple="false"
                    v-bind:allow-reorder="false"
                    accepted-file-types="video/mp4"
                    :server="server"
                    v-bind:files="filepond_content_edit"
                />
            </div>

            <button @click="save()" :disabled="!views.saveButton" class="btn btn-primary">Сохранить</button>
            <button @click="del()" v-if="$route.params.id" class="btn btn-outline-danger ms-2">Удалить</button>
        </div>

    </div>
</template>

<script>
import vueFilePond from "vue-filepond"
import "filepond/dist/filepond.min.css"
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type"
import FilePondPluginImagePreview from "filepond-plugin-image-preview"

const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview
)

export default {
    data() {
        return {
            banner: {},

            name: '',
            content: '',

            selected: {
                type: 'image'
            },

            filepond_content: [],
            filepond_content_edit: [],

            views: {
                loading: true,
                saveButton: true,
            },

            server: {
                remove(filename, load) {
                    load('1');
                },
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    const formData = new FormData();
                    formData.append(fieldName, file, file.name);
                    const request = new XMLHttpRequest();
                    request.open('POST', '/api/admin/file/upload');
                    request.upload.onprogress = (e) => {
                        progress(e.lengthComputable, e.loaded, e.total);
                    };
                    request.onload = function() {
                        if (request.status >= 200 && request.status < 300) {
                            load(request.responseText);
                        }
                        else {
                            error('oh no');
                        }
                    };
                    request.send(formData);
                    return {
                        abort: () => {
                            request.abort();
                            abort();
                        }
                    };
                },
                revert: (filename, load) => {
                    load(filename)
                },
                load: (source, load, error, progress, abort, headers) => {
                    var myRequest = new Request(source);
                    fetch(myRequest).then(function(response) {
                        response.blob().then(function(myBlob) {
                            load(myBlob)
                        });
                    });
                },
            },
        }
    },
    created() {
        if(this.$route.params.id) {
            this.loadBanner()
        }

        if(!this.$route.params.id) {
            this.views.loading = false
        }
    },
    methods: {
        loadBanner() {
            axios.get(`/api/admin/banner/${this.$route.params.id}`)
            .then(response => {
                this.banner = response.data

                this.name = response.data.name
                this.type = response.data.type

                if(response.data.content) {
                    this.filepond_content_edit = [
                        {
                            source: response.data.content,
                            options: {
                                type: 'local',
                            }
                        }
                    ]
                }

                this.views.loading = false
            })
        },
        save() {
            if(this.selected.type == 'image') {
                if(document.getElementsByName("banner_image")[0]) {
                    this.content = document.getElementsByName("banner_image")[0].value
                }
            }
            if(this.selected.type == 'video') {
                if(document.getElementsByName("banner_video")[0]) {
                    this.content = document.getElementsByName("banner_video")[0].value
                }
            }

            if(!this.name) {
                return this.$swal({
                    text: 'Укажите название',
                    icon: 'error',
                })
            }

            if(!this.content) {
                return this.$swal({
                    text: 'Загрузите изображение или видео',
                    icon: 'error',
                })
            }

            this.views.saveButton = false

            if(this.$route.params.id) {
                axios.put(`/api/admin/banner/${this.$route.params.id}/update`, {
                    name: this.name,
                    type: this.selected.type,
                    content: this.content,
                })
                .then(response => {
                    this.views.saveButton = true
    
                    this.$router.push({ name: 'Banners' })
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
                axios.post(`/api/admin/banners`, {
                    name: this.name,
                    type: this.selected.type,
                    content: this.content,
                })
                .then(response => {
                    this.views.saveButton = true
    
                    this.$router.push({ name: 'Banners' })
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
            if(confirm('Точно удалить баннер?')) {
                axios.delete(`/api/admin/banner/${this.$route.params.id}/delete`)
                .then(response => {
                    this.$router.push({ name: 'Banners' })
                })
                .catch(errors => {
                    return this.$swal({
                        text: 'Ошибка',
                        icon: 'error',
                    })
                })
            }
        },
    },
    components: {
        FilePond
    }
}
</script>