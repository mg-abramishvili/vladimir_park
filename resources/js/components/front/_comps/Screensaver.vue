<template>
    <div class="screensaver-content">

        <swiper v-if="slides.length"
            :slides-per-view="1"
            :space-between="0"
            :loop="false"
            :autoplayDisableOnInteraction="false"
            :allow-touch-move="false"
            :speed="1"
            @swiper="onSwiper"
            class="ScreensaverHooper">
            
            <swiper-slide v-for="(slide, index) in slides" class="ScreensaverHooper-slide">
                <img v-if="slide.type == 'image' && slide.content" :src="slide.content"/>
                <video v-if="slide.type == 'video' && slide.content" :id="'video_' + slide.id" nocontrols>
                    <source :src="slide.content" type="video/mp4">
                </video>
            </swiper-slide>
        </swiper>
        
    </div>
</template>

<script>
import { Swiper, SwiperSlide } from 'swiper/vue'
import 'swiper/swiper.min.css'

export default {
    props: ['slides'],
    data() {
        return {
            timeout: ''
        }
    },
    created() {
        setTimeout(() => { this.slideTo(0) }, 500)
    },
    methods: {
        onSwiper(swiper) {
            this.swiper = swiper
        },
        slideTo(index) {
            this.swiper.slideTo(index)

            this.timeout = ''
            
            let currentSlide = this.slides[index]
            let nextSlide = 0
            let duration = 0

            if(this.slides[index + 1]) {
                nextSlide = index + 1
            }

            if(currentSlide.type == 'video') {
                let video = document.getElementById('video_' + this.slides[index].id)

                video.pause()
                video.currentTime = 0
                video.play()
                
                duration = Math.floor(video.duration * 10) / 10 * 1000
            } else {
                duration = 5000
            }

            this.timeout = setTimeout(() => {
                if(this.$parent.screensaver.isActive) {
                    this.slideTo(nextSlide)
                }
            }, duration)
        },
        stopSlide() {
            clearTimeout(this.timeout)
        },
    },
    components: {
        Swiper,
        SwiperSlide,
    }
}
</script>

<style>
    .screensaver {
        background-color: #000;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100vw;
        height: 100vh;
        z-index: 999999;
        overflow: hidden;
    }

    .screensaver-inner {
        height: 100vh;
        width: 100vw;
        position: relative;
        overflow: hidden;
    }

    .screensaver-content {
        width: 100vw;
        height: 100vh;
        overflow: hidden;
    }

    .ScreensaverHooper {
        width: 100vw;
        height: 100vh;
        overflow: hidden;
    }

    .ScreensaverHooper-slide {
        width: 100vw;
        height: 100vh;
        position: relative;
        overflow: hidden;
    }
    .ScreensaverHooper-slide:after {
        content: "";
        position: absolute;
        top: auto;
        left: 0;
        right: 0;
        width: 15vh;
        height: 15vh;
        z-index: 10;
        background: url(/img/touch-icon.png);
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
        margin: 0 auto;
        bottom: 10vh;
        opacity: 0.5;
    }

    .ScreensaverHooper-slide img,
    .ScreensaverHooper-slide video {
        width: auto;
        height: auto;
        max-width: 100vw;
        max-height: 100vh;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: -1;
    }

    .ScreensaverHooper .hooper-track {
        transition: none !important;
    }

    .ScreensaverHooper .hooper-slide, .hooper-slide.is-prev, .hooper-slide.is-next {
        transition: all 0s ease-in-out;
        opacity: 0 !important;
    }

    .ScreensaverHooper .hooper-slide.is-active {
        opacity: 1 !important;
    }
</style>