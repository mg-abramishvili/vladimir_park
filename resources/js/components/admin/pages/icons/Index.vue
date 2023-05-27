<template>
    <div class="modal fade show" tabindex="-1" style="display:block">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Иконки</h5>
                    <button @click="$parent.views.icons = false" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <div>
                        <file-pond
                            name="icon_image"
                            ref="icon_image"
                            label-idle="Загрузить новую иконку"
                            v-bind:allow-multiple="false"
                            v-bind:allow-reorder="false"
                            accepted-file-types="image/jpeg, image/png"
                            :server="server"
                            v-bind:files="filepond_image_edit"
                        />

                        <div v-if="icons.length" class="row">
                            <div v-for="icon in icons" class="col-3">
                                <div @click="selectIcon(icon)" class="icon-item mb-3">
                                    <img :src="icon.image" alt="">
                                </div>
                            </div>
                        </div>

                        <p v-else class="m-0">Иконок нет.</p>
                    </div>
                </div>
            </div>
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
    props: ['icons'],
    data() {
        return {
            icon: '',

            filepond_image: [],
            filepond_image_edit: [],

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
                    request.onload = () => {
                        if (request.status >= 200 && request.status < 300) {
                            load(request.responseText);

                            setTimeout(() => {
                                this.save()
                            }, 1000)
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
        //
    },
    methods: {
        selectIcon(icon) {
            this.$parent.selected.icon = icon

            this.$parent.views.icons = false
        },
        save() {
            setTimeout(() => {
                if(document.getElementsByName("icon_image")[0]) {
                    this.icon = document.getElementsByName("icon_image")[0].value
                }
    
                if(!this.icon) {
                    return this.$swal({
                        text: 'Загрузите картинку',
                        icon: 'error',
                    })
                }
    
                axios.post(`/api/admin/icons`, {
                    image: this.icon
                })
                .then(response => {
                    this.icon = ''
    
                    this.filepond_image_edit = []
    
                    this.$parent.loadIcons()
                })
                .catch(errors => {
                    return this.$swal({
                        text: 'Ошибка',
                        icon: 'error',
                    })
                })
            }, 1000)
        }
    },
    components: {
        FilePond
    }
}
</script>