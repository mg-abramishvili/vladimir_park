<template>
    <div class="home">
        <div class="banners">
            <swiper v-if="banners.length"
                :slides-per-view="1"
                :allow-touch-move="false"
                @swiper="onSwiperBanners"
                class="banners-slider">
                
                <swiper-slide v-for="(banner, index) in banners" class="banner-item">
                    <div v-if="banner.type == 'image'" class="banner-item-image" v-bind:style="{ 'background-image': 'url(' + banner.content + ')' }"></div>
                </swiper-slide>
            </swiper>
        </div>

        <Sidebar v-if="$config.orientation == 'vertical'" />

        <div class="menu">
            <swiper v-if="pages.length"
                :slides-per-view="4"
                direction="vertical"
                :allow-touch-move="true"
                @swiper="onSwiperMenu"
                class="menu-slider">
                
                <swiper-slide v-for="(page, index) in pages" @click="goToPage(page)" class="menu-item">
                    <div class="menu-item-image" v-bind:style="{ 'background-image': 'url(' + page.icon.image + ')' }"></div>
                    <span>{{ page.name }}</span>
                </swiper-slide>
            </swiper>
        </div>

        <button v-if="pages.length > 6" @click="prev()" class="page-block-navigation page-block-navigation-prev">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
            </svg>
        </button>
        <button v-if="pages.length > 6" @click="next()" class="page-block-navigation page-block-navigation-next">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
            </svg>
        </button>
    </div>
</template>

<script>
import Sidebar from '../sidebar.vue'

import { Swiper, SwiperSlide } from 'swiper/vue'
import 'swiper/swiper.min.css'

export default {
    props: ['pages', 'banners'],
    data() {
        return {
            views: {
                sliderArrows: true,
            }
        }
    },
    methods: {
        onSwiperMenu(swiper) {
            this.swiperMenu = swiper
        },
        onSwiperBanners(swiper) {
            this.swiperBanners = swiper
        },
        goToPage(page) {
            this.$parent.goToPage(page)
        },
        prev() {
            this.swiperMenu.slidePrev()
        },
        next() {
            this.swiperMenu.slideNext()
        },
        slideToZero() {
            this.swiperMenu.slideTo(0)
            this.swiperBanners.slideTo(0)
        }
    },
    components: {
        Swiper,
        SwiperSlide,
        Sidebar,
    },
}
</script>