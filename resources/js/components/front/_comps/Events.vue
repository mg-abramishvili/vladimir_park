<template>
    <template v-if="!views.loading && events.length">
        <swiper
            :slides-per-view="1"
            :space-between="0"
            :allow-touch-move="true"
            :center-insufficient-slides="true"
            @swiper="onSwiper"
            class="events-slider">
            
            <swiper-slide v-for="(event, index) in events" class="event-item">
                <div class="event-item-poster" v-bind:style="{ 'background-image': 'url(' + event.poster + ')' }"></div>
                <span>{{ $dayjs(event.date).locale('ru').format('D MMMM YYYY') }} - {{ event.name }}<br><br>{{ event.description }}</span>
            </swiper-slide>
        </swiper>

        <button v-if="events.length > 1" @click="prev()" class="events-navigation events-navigation-prev">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
            </svg>
        </button>
        <button v-if="events.length > 1" @click="next()" class="events-navigation events-navigation-next">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
            </svg>
        </button>
    </template>

    <p v-if="!views.loading && !events.length" class="text-danger">Афиша пуста.</p>
</template>

<script>
import { Swiper, SwiperSlide } from 'swiper/vue'
import 'swiper/swiper.min.css'

export default {
    data() {
        return {
            events: [],

            views: {
                loading: true,
            }
        }
    },
    created() {
        this.loadEvents()
    },
    methods: {
        loadEvents() {
            axios.get('/api/events')
            .then(response => {
                this.events = response.data

                this.views.loading = false
            })
        },
        onSwiper(swiper) {
            this.swiper = swiper
        },
        prev() {
            this.swiper.slidePrev()
        },
        next() {
            this.swiper.slideNext()
        },
        slideToZero() {
            this.swiper.slideTo(0)
        }
    },
    components: {
        Swiper,
        SwiperSlide,
    }
}
</script>