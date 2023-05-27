<template>
    <div class="modal fade show" tabindex="-1" style="display:block">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Редактирование блока</h5>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                
                <TextMaster v-if="block.type == 'text'" :block="block" />
                
                <ImageMaster v-if="block.type == 'image'" :block="block" />
                
                <ImageSliderMaster v-if="block.type == 'image_slider'" :block="block" />
                
                <VideoMaster v-if="block.type == 'video'" :block="block" />

                <AudioMaster v-if="block.type == 'audio'" :block="block" />
                
                <PdfMaster v-if="block.type == 'pdf'" :block="block" />
                
                <ExcelMaster v-if="block.type == 'excel'" :block="block" />
                
                <IframeMaster v-if="block.type == 'iframe'" :block="block" />
            </div>
        </div>
    </div>
</template>

<script>
import TextMaster from './types/TextMaster.vue'
import ImageMaster from './types/ImageMaster.vue'
import ImageSliderMaster from './types/ImageSliderMaster.vue'
import VideoMaster from './types/VideoMaster.vue'
import AudioMaster from './types/AudioMaster.vue'
import PdfMaster from './types/PdfMaster.vue'
import ExcelMaster from './types/ExcelMaster.vue'
import IframeMaster from './types/IframeMaster.vue'

export default {
    props: ['block'],
    data() {
        return {
            //
        }
    },
    created() {
        //
    },
    methods: {
        save(content) {
            this.$parent.blocks.find(block => block.id == this.block.id).content = content

            this.closeModal()
        },
        closeModal() {
            this.$parent.selected.block = ''
        },
    },
    components: {
        TextMaster,
        ImageMaster,
        ImageSliderMaster,
        VideoMaster,
        AudioMaster,
        PdfMaster,
        ExcelMaster,
        IframeMaster,
    }
}
</script>