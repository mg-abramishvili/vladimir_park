<template>
    <div class="modal-body">
        <label class="form-label">URL</label>
        <input v-model="content" type="text" class="form-control">
    </div>
    <div class="modal-footer">
        <button @click="save()" type="button" class="btn btn-primary">Сохранить</button>
        <button @click="cancel()" type="button" class="btn btn-outline-secondary">Отмена</button>
    </div>
</template>

<script>
export default {
    props: ['block'],
    data() {
        return {
            content: '',
        };
    },
    created() {
        this.content = this.block.content
    },
    methods: {
        save() {
            if(!this.content) {
                return this.$swal({
                    text: 'Укажите URL',
                    icon: 'error',
                })
            }

            this.$parent.save(this.content)
        },
        cancel() {
            this.$parent.closeModal()
        },
    },
}
</script>