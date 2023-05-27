<template>
    <div>
        <div class="content-header px-4">
            <h1>
                Настройки
            </h1>
        </div>

        <div v-if="views.loading" class="p-4">
            <Loader />
        </div>

        <div v-if="!views.loading" class="content p-4">
            <div class="mb-4">
                <label class="form-label">Заголовок</label>
                <input v-model="title" type="text" class="form-control">
            </div>
            <div class="mb-4">
                <label class="form-label">Логотип</label>
                <file-pond
                    name="logo_image"
                    ref="logo_image"
                    label-idle="Выбрать файл"
                    v-bind:allow-multiple="false"
                    v-bind:allow-reorder="false"
                    accepted-file-types="image/jpeg, image/png"
                    :server="server"
                    v-bind:files="filepond_image_edit"
                />
            </div>

            <button @click="save()" :disabled="!views.saveButton" class="btn btn-primary">Сохранить</button>
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
            config: {},

            title: '',
            logo: '',

            filepond_image: [],
            filepond_image_edit: [],

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
        this.loadConfig()
    },
    methods: {
        loadConfig() {
            axios.get(`/api/admin/config`)
            .then(response => {
                this.config = response.data

                this.title = response.data.title

                if(response.data.logo) {
                    this.filepond_image_edit = [
                        {
                            source: response.data.logo,
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
            if(document.getElementsByName("logo_image")[0]) {
                this.logo = document.getElementsByName("logo_image")[0].value
            }

            if(!this.title) {
                return this.$swal({
                    text: 'Укажите заголовок',
                    icon: 'error',
                })
            }

            if(!this.logo) {
                return this.$swal({
                    text: 'Загрузите логотип',
                    icon: 'error',
                })
            }

            this.views.saveButton = false

            axios.put(`/api/admin/config-update`, {
                title: this.title,
                logo: this.logo
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
    components: {
        FilePond
    }
}
</script>