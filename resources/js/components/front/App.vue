<template v-if="$config">
    <Vuz2Theme v-if="$config.theme == 'vuz2'" ref="vuz2" />

    <MuzeiTheme v-if="$config.theme == 'muzei'" ref="muzei" />

    <div v-if="screensaver.isActive && screensaver.slides.length" class="screensaver">
        <div @click="closeScreensaver()" class="screensaver-inner">
            <Screensaver ref="screensaver" :slides="screensaver.slides" />
        </div>
    </div>
</template>

<script>
    import Vuz2Theme from './vuz2/layout.vue'
    import MuzeiTheme from './muzei/layout.vue'

    import Screensaver from './_comps/Screensaver.vue'
    
    export default {
        data() {
            return {
                screensaver: {
                    isActive: true,
                    timeoutID: '',
                    timer: 60000,
                    slides: [],
                },

                checkFocusI: 0,
            }
        },
        created() {
            this.loadScreensaverSlides()
        },
        methods: {
            loadScreensaverSlides() {
                axios.get(`/api/screensavers`)
                .then(response => {
                    this.screensaver.slides = response.data
                    
                })
            },
            initScreensaver() {
                window.addEventListener("click", this.ScreensaverResetTimer)
                window.addEventListener("mousemove", this.ScreensaverResetTimer)
                window.addEventListener("mousedown", this.ScreensaverResetTimer)
                window.addEventListener("keypress", this.ScreensaverResetTimer)
                window.addEventListener("touchstart", this.ScreensaverResetTimer)
                window.addEventListener("touchmove", this.ScreensaverResetTimer)
                window.addEventListener("scroll", this.ScreensaverResetTimer)
            },
            ScreensaverStartTimer() {
                this.screensaver.timeoutID = window.setTimeout(this.ScreensaverGoInactive, this.screensaver.timer)
            },
            ScreensaverResetTimer() {
                window.clearTimeout(this.screensaver.timeoutID)

                this.ScreensaverStartTimer()
            },
            ScreensaverGoInactive() {
                this.screensaver.isActive = true

                this.ScreensaverResetTimer()
            },
            closeScreensaver() {
                if(this.$refs.screensaver) {
                    this.$refs.screensaver.stopSlide()
                }

                this.screensaver.isActive = false

                this.ScreensaverResetTimer()
            },
            checkFocus() {
                if(document.activeElement == document.getElementById("page-block-pdf")) {
                    console.log("clicked "+(this.checkFocusI++))
                    window.focus()
                }
            }
        },
        mounted() {
            this._keyListener = function(e) {
                if(e.key === 'q' && (e.ctrlKey || e.metaKey) || e.key === 'й' && (e.ctrlKey || e.metaKey)) {
                    e.preventDefault()
                    window.location.href = '/admin'
                }
            }
            document.addEventListener('keydown', this._keyListener.bind(this))

            this.initScreensaver()

            this.ScreensaverStartTimer()

            window.setInterval(this.checkFocus, 100)
        },
        beforeMount() {
            // document.oncontextmenu = new Function("return false")
        },
        components: {
            Vuz2Theme,
            MuzeiTheme,
            Screensaver,
        }
    }
</script>