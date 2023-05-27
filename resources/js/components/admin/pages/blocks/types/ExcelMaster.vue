<template>
    <div class="modal-body">
        <file-pond
            name="block_excel"
            ref="block_excel"
            label-idle="Выбрать файл"
            v-bind:allow-multiple="false"
            v-bind:allow-reorder="false"
            accepted-file-types="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            :server="server"
            v-bind:files="filepond_excel_edit"
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
            content: '',

            filepond_excel: [],
            filepond_excel_edit: [],

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
            this.filepond_excel_edit = [
                {
                    source: this.block.content,
                    options: {
                        type: 'local',
                    }
                }
            ]
        }
    },
    methods: {
        save() {
            if(document.getElementsByName("block_excel")[0]) {
                this.content = document.getElementsByName("block_excel")[0].value
            }

            if(!this.content) {
                return this.$swal({
                    text: 'Загрузите XLSX-файл',
                    icon: 'error',
                })
            }

            this.$parent.save(this.content)
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