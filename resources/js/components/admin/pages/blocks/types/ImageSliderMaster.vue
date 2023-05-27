<template>
    <div class="modal-body">
        <file-pond
            name="block_images[]"
            ref="block_images"
            label-idle="Выбрать файлы"
            v-bind:allow-multiple="true"
            v-bind:allow-reorder="true"
            v-bind:allow-image-preview="true"
            accepted-file-types="image/jpeg, image/png"
            :server="server"
            v-bind:files="filepond_image_edit"
        />
    </div>
    <div class="modal-footer">
        <button @click="save()" type="button" class="btn btn-primary">Сохранить</button>
        <button @click="cancel()" type="button" class="btn btn-outline-secondary">Отмена</button>
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
    props: ['block'],
    data() {
        return {
            content: [],

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
        };
    },
    created() {
        if(this.block.content) {
            this.filepond_image_edit = this.block.content.split(',').map(function(element){
                {
                    return {
                        source: element,
                        options: {
                            type: 'local',
                        }
                    } 
                }
            })
        }
    },
    methods: {
        save() {
            if(document.getElementsByName("block_images[]")) {
                this.content = []
                document.getElementsByName("block_images[]").forEach((imageItem) => {
                    if(imageItem.value) {
                        this.content.push(imageItem.value)
                    }
                })
            }

            if(!this.content.length) {
                return this.$swal({
                    text: 'Загрузите изображения',
                    icon: 'error',
                })
            }

            this.$parent.save(this.content.join())
        },
        cancel() {
            this.$parent.closeModal()
        },
    },
    components: {
        FilePond
    }
}
</script>