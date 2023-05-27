<template>
    <div class="vuz2-layout">
        <header>
            <div class="logo">
                <img :src="config.logo" alt="">
            </div>
            <div class="title">
                <p>{{ config.title }}</p>
            </div>
            <div class="datetime">
                <p class="time">{{ time }}</p>
                <p class="date">{{ date }}</p>
            </div>
        </header>

        <router-view v-slot="{ Component }">
            <keep-alive>
                <component :is="Component" :key="$route.path" />
            </keep-alive>
        </router-view>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                time: '',
                date: '',
            }
        },
        computed: {
            config() {
                return this.$root.config
            }
        },
        mounted() {
            setInterval(this.currentTime, 1000)
            setInterval(this.currentDate, 1000)
        },
        methods: {
            currentTime() {
                this.time = this.$dayjs().locale('ru').format('H:mm')
            },
            currentDate() {
                this.date = this.$dayjs().locale('ru').format('D MMMM, dddd')
            },
        }
    }
</script>