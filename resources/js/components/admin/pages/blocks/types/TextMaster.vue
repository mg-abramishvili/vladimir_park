<template>
    <div class="modal-body">
        <ckeditor :editor="editor" v-model="content" :config="editorConfig"></ckeditor>
    </div>
    <div class="modal-footer">
        <button @click="save()" type="button" class="btn btn-primary">Сохранить</button>
        <button @click="cancel()" type="button" class="btn btn-outline-secondary">Отмена</button>
    </div>
</template>

<script>
import CKEditor from '@ckeditor/ckeditor5-vue'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'

export default {
    props: ['block'],
    data() {
        return {
            content: '',

            editor: ClassicEditor,
            editorConfig: {
                toolbar: [ 'bold', 'italic', '|', 'alignment', '|', 'bulletedList', 'numberedList', '|', 'insertTable', '|', 'undo', 'redo' ],
            },
        };
    },
    created() {
        this.content = this.block.content
    },
    methods: {
        save() {
            if(!this.content) {
                return this.$swal({
                    text: 'Напишите текст',
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
        ckeditor: CKEditor.component,
    }
}
</script>