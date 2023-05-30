<template>
    <template v-if="$config.theme == 'vuz2'">
        <Vuz2Horizontal
            v-if="$config.orientation == 'horizontal'"
            ref="vuz2"
            :page="page"
            :kiosk="$route.params.kiosk" />
    </template>

    <template v-if="$config.theme == 'muzei'">
        <MuzeiVertical
            v-if="$config.orientation == 'vertical'"
            ref="muzei"
            :page="page"
            :kiosk="$route.params.kiosk" />
    </template>
</template>

<script>
import Vuz2Horizontal from './vuz2/pages/horizontal.vue'
import MuzeiVertical from './muzei/pages/vertical.vue'

export default {
    data() {
        return {
            page: {},
        }
    },
    created() {
        this.loadPage()
    },
    methods: {
        loadPage() {
            axios.get(`/api/page/${this.$route.params.id}`)
            .then(response => {
                this.page = response.data
            })
        },
        goTo(fromPage, toPage) {
            if(fromPage) {
                if(fromPage.is_folder && fromPage.children && fromPage.children.length) {
                    if(this.$config.theme == 'vuz2') {
                        this.$refs.vuz2.slideToZero()
                    }
                    if(this.$config.theme == 'muzei') {
                        this.$refs.muzei.slideToZero()
                    }
                }

                if(fromPage.blocks && fromPage.blocks.length) {
                    fromPage.blocks.forEach(block => {
                        if(block.type == 'video') {
                            let video = document.getElementById('video_' + block.id)
        
                            if(video) {
                                video.load()
                            }
                        }
                        if(block.type == 'audio') {
                            let audio = document.getElementById('audio_' + block.id)
        
                            if(audio) {
                                audio.load()
                            }
                        }
        
                        if(block.type == 'routes') {
                            if(this.$config.theme == 'vuz2') {
                                this.$refs.vuz2.$refs.routes[0].closeSearchPanel()
                                this.$refs.vuz2.$refs.routes[0].resetRoutes()
                                this.$refs.vuz2.$refs.routes[0].zoomReset()
                                this.$refs.vuz2.$refs.routes[0].slideToZero()
                            }
                            if(this.$config.theme == 'muzei') {
                                this.$refs.muzei.$refs.routes[0].closeSearchPanel()
                                this.$refs.muzei.$refs.routes[0].resetRoutes()
                                this.$refs.muzei.$refs.routes[0].zoomReset()
                                this.$refs.muzei.$refs.routes[0].slideToZero()
                            }
                        }

                        if(block.type == 'events') {
                            if(this.$config.theme == 'vuz2') {
                                this.$refs.vuz2.$refs.events[0].slideToZero()
                            }
                            if(this.$config.theme == 'muzei') {
                                this.$refs.muzei.$refs.events[0].slideToZero()
                            }
                        }

                        if(block.type == 'image_slider') {
                            if(this.$config.theme == 'vuz2') {
                                this.$refs.vuz2.slideToZero()
                            }
                            if(this.$config.theme == 'muzei') {
                                this.$refs.muzei.slideToZero()
                            }
                        }
                    })
                }
            }

            if(toPage) {
                if(toPage == 'home') {
                    this.$router.push({ name: 'Home', params: { kiosk: this.$route.params.kiosk } })
                } else {
                    if(toPage.blocks && toPage.blocks.length) {
                        toPage.blocks.forEach(block => {
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

                    this.$router.push({ name: 'Page', params: { id: toPage.id, kiosk: this.$route.params.kiosk } })
                }
            }
        },
    },
    components: {
        Vuz2Horizontal,
        MuzeiVertical,
    }
}
</script>