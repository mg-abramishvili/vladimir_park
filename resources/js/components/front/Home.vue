<template>
    <template v-if="$config.theme == 'vuz2'">
        <Vuz2Horizontal
            v-if="$config.orientation == 'horizontal'"
            ref="vuz2"
            :pages="pages"
            :banners="banners" />
    </template>

    <template v-if="$config.theme == 'muzei'">
        <MuzeiVertical
            v-if="$config.orientation == 'vertical'"
            ref="muzei"
            :pages="pages"
            :banners="banners" />
    </template>
</template>

<script>
import Vuz2Horizontal from './vuz2/home/horizontal.vue'
import MuzeiVertical from './muzei/home/vertical.vue'

export default {
    data() {
        return {
            pages: [],
            banners: [],
        }
    },
    created() {
        this.loadPages()
        this.loadBanners()
    },
    methods: {
        loadPages() {
            axios.get('/api/pages')
            .then(response => {
                this.pages = response.data
            })
        },
        loadBanners() {
            axios.get('/api/banners')
            .then(response => {
                this.banners = response.data
            })
        },
        goToPage(page) {
            if(this.$config.theme == 'vuz2') {
                this.$refs.vuz2.slideToZero()
            }
            if(this.$config.theme == 'muzei') {
                this.$refs.muzei.slideToZero()
            }

            if(page.blocks && page.blocks.length) {
                page.blocks.forEach(block => {
                    if(block.type == 'video') {
                        setTimeout(() => {
                            let video = document.getElementById('video_' + block.id)
    
                            if(video) {
                                video.play()
                            }
                        }, 100)
                    }
                    if(block.type == 'audio') {
                        setTimeout(() => {
                            let audio = document.getElementById('audio_' + block.id)
    
                            if(audio) {
                                audio.play()
                            }
                        }, 100)
                    }
                })
            }

            this.$router.push({name: 'Page', params: {id: page.id}})
        },
    },
    components: {
        Vuz2Horizontal,
        MuzeiVertical,
    }
}
</script>