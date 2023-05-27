<template>
    <div>
        <div class="content-header px-4">
            <h1>
                <router-link :to="{name: 'Kiosks'}" class="btn btn-back">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                    </svg>
                </router-link>

                <template v-if="$route.params.id">
                    {{ kiosk.name }}
                </template>
                <template v-else>
                    Новый киоск
                </template>
            </h1>
        </div>

        <div v-if="views.loading" class="p-4">
            <Loader />
        </div>

        <div v-if="!views.loading" class="content p-4">
            <div class="mb-4">
                <label class="form-label">Название</label>
                <input v-model="name" type="text" class="form-control">
            </div>

            <div class="mb-4">
                <label class="form-label">Схема</label>
                <select v-model="selected.scheme" class="form-select">
                    <option v-for="scheme in schemes" :value="scheme">{{ scheme.name }}</option>
                </select>
            </div>

            <div @click="createPoint($event)" class="point-drawing-area">
                <img :src="selected.scheme.image" alt="">
            </div>

            <button @click="save()" :disabled="!views.saveButton" class="btn btn-primary">Сохранить</button>
        </div>

    </div>
</template>

<script>

export default {
    data() {
        return {
            kiosk: {},

            name: '',
            x: '',
            y: '',

            schemes: [],

            selected: {
                scheme: '',
            },

            views: {
                loading: true,
                saveButton: true,
            },
        }
    },
    created() {
        this.loadSchemes()

        if(this.$route.params.id) {
            this.loadKiosk()
        }

        if(!this.$route.params.id) {
            this.views.loading = false
        }
    },
    methods: {
        loadSchemes() {
            axios.get(`/api/admin/schemes`)
            .then(response => {
                this.schemes = response.data
            })
        },
        loadKiosk() {
            axios.get(`/api/admin/kiosk/${this.$route.params.id}`)
            .then(response => {
                this.kiosk = response.data

                this.name = response.data.name
                this.x = response.data.x
                this.y = response.data.y

                this.selected.scheme = this.schemes.find(scheme => scheme.id == response.data.scheme_id)

                this.views.loading = false

                setTimeout(() => {
                    this.renderPoint()
                }, 1000)
            })
        },
        createPoint(event) {
            let map = document.getElementsByClassName('point-drawing-area')[0]

            this.x = event.pageX - map.offsetLeft
            this.y = event.pageY - map.offsetTop

            this.renderPoint()
        },
        renderPoint() {
            let map = document.getElementsByClassName('point-drawing-area')[0]

            let svgs = map.getElementsByTagName("svg")
            for (var i = 0; i < svgs.length; i++) {
                svgs[i].remove()
            }

            let xmlns = "http://www.w3.org/2000/svg"
            let svg = document.createElementNS(xmlns, "svg")
            let circle = document.createElementNS(xmlns,'circle')

            circle.setAttribute('fill','#f33')
            circle.setAttribute('cx', this.x)
            circle.setAttribute('cy', this.y)
            circle.setAttribute('r', 4)

            svg.appendChild(circle)
            map.appendChild(svg)
        },
        save() {
            if(!this.x || !this.y) {
                return this.$swal({
                    text: 'Укажите координаты',
                    icon: 'error',
                })
            }

            this.views.saveButton = false

            if(this.$route.params.id) {
                axios.put(`/api/admin/kiosk/${this.$route.params.id}/update`, {
                    name: this.name,
                    scheme_id: this.selected.scheme.id,
                    x: this.x,
                    y: this.y
                })
                .then(response => {
                    this.views.saveButton = true
    
                    this.$router.push({ name: 'Kiosks' })
                })
                .catch(errors => {
                    this.views.saveButton = true
                    
                    return this.$swal({
                        text: 'Ошибка',
                        icon: 'error',
                    })
                })
            }

            if(!this.$route.params.id) {
                axios.post(`/api/admin/kiosks`, {
                    name: this.name,
                    scheme_id: this.selected.scheme.id,
                    x: this.x,
                    y: this.y
                })
                .then(response => {
                    this.views.saveButton = true
    
                    this.$router.push({ name: 'Kiosks' })
                })
                .catch(errors => {
                    this.views.saveButton = true
                    
                    return this.$swal({
                        text: 'Ошибка',
                        icon: 'error',
                    })
                })
            }
        }
    },
}
</script>