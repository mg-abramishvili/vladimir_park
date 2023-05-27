<template>
    <div>
        <div class="content-header px-4">
            <h1>
                <router-link :to="{name: 'Routes', params: {kiosk: 1} }" class="btn btn-back">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                    </svg>
                </router-link>

                <template v-if="$route.params.id && route.kiosk">
                    {{ route.kiosk.name }}
                </template>
                <template v-else>
                    Новый маршрут
                </template>
            </h1>
        </div>
        
        <div v-if="views.loading" class="p-4">
            <Loader />
        </div>

        <div v-if="!views.loading" class="content p-4">
            <div class="mb-4">
                <label for="form-label">Киоск</label>
                <select v-model="selected.kiosk" class="form-select">
                    <option v-for="kiosk in kiosks" :value="kiosk">{{ kiosk.name }}</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="form-label">Название</label>
                <input v-model="name" type="text" class="form-control">
            </div>

            <div class="mb-4">
                <label for="form-label">Схема 1</label>
                <select v-model="selected.scheme1" class="form-control mb-2">
                    <option v-for="scheme in schemes" :key="'key_' + scheme.id" :value="scheme">{{ scheme.name }}</option>
                </select>
                
                <div class="text-center mb-2">
                    <button @click="undoDotFloor1" class="btn btn-sm btn-outline-danger">&larr;</button>
                </div>

                <div v-if="selected.scheme1" id="wrapper-map" class="wrapper-map mb-4" @click="clickOnMapScheme($event, 1)">
                    <img :src="selected.scheme1.image" alt="">
                    <svg xmlns="http://www.w3.org/2000/svg" id="map-path" class="map-path"></svg>
                </div>

                <!-- <div class="row">
                    <div class="col-6">
                        <label for="form-label">Текст к первой точке</label>
                        <input v-model="floor1_text_begin" type="text" class="form-control">
                    </div>
                    <div class="col-6">
                        <label for="form-label">Текст к последней точке</label>
                        <input v-model="floor1_text_end" type="text" class="form-control">
                    </div>
                </div> -->
            </div>

            <div class="mb-4">
                <label for="form-label">Схема 2</label>
                <select v-model="selected.scheme2" class="form-control mb-2">
                    <option v-for="scheme in schemes" :key="'key_' + scheme.id" :value="scheme">{{ scheme.name }}</option>
                </select>
                
                <div class="text-center mb-2">
                    <button @click="undoDotFloor2" class="btn btn-sm btn-outline-danger">&larr;</button>
                </div>

                <div v-if="selected.scheme2" id="wrapper-map2" class="wrapper-map mb-4" @click="clickOnMapScheme($event, 2)">
                    <img :src="selected.scheme2.image" alt="">
                    <svg xmlns="http://www.w3.org/2000/svg" id="map-path2" class="map-path"></svg>
                </div>

                <!-- <div class="row">
                    <div class="col-6">
                        <label for="form-label">Текст к первой точке</label>
                        <input v-model="floor2_text_begin" type="text" class="form-control">
                    </div>
                    <div class="col-6">
                        <label for="form-label">Текст к последней точке</label>
                        <input v-model="floor2_text_end" type="text" class="form-control">
                    </div>
                </div> -->
            </div>

            <button @click="save()" class="btn btn-primary">Сохранить</button>
            <button @click="del()" v-if="$route.params.id" class="btn btn-outline-danger ms-2">Удалить</button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                schemes: [],
                kiosks: [],

                route: '',

                selected: {
                    kiosk: '',
                    scheme1: '',
                    scheme2: '',
                },

                name: '',
                route_code_floor1: [],
                route_code_floor2: [],

                floor1_text_begin: '',
                floor1_text_end: '',
                floor2_text_begin: '',
                floor2_text_end: '',

                views: {
                    loading: true,
                }
            }
        },
        created() {
            this.loadKiosks()
        },
        methods: {
            loadKiosks() {
                axios.get('/api/admin/kiosks')
                .then(response => {
                    this.kiosks = response.data

                    this.loadSchemes()
                })
            },
            loadSchemes() {
                axios.get('/api/admin/schemes')
                .then(response => {
                    this.schemes = response.data

                    if(this.$route.params.id) {
                        this.loadRoute()
                    } else {
                        this.views.loading = false
                    }
                })
            },
            loadRoute() {
                axios.get(`/api/admin/route/${this.$route.params.id}`)
                .then(response => {
                    this.route = response.data

                    this.name = response.data.name

                    this.selected.kiosk = this.kiosks.find(k => k.id == response.data.kiosk_id)
                    this.selected.scheme1 = this.schemes.find(s => s.id == response.data.scheme1_id)

                    if(response.data.scheme2_id) {
                        this.selected.scheme2 = this.schemes.find(s => s.id == response.data.scheme2_id)
                    }

                    setTimeout(() => {
                        response.data.route_code_floor1.forEach((i, index) => {
                            setTimeout(() => {
                                this.route_code_floor1.push(i)

                                this.renderPath(i, 1)
                            }, (index + 1) * 100)
                        })

                        if(response.data.route_code_floor2) {
                            response.data.route_code_floor2.forEach((i, index) => {
                                setTimeout(() => {
                                    this.route_code_floor2.push(i)
                                    
                                    this.renderPath(i, 2)
                                }, (index + 1) * 100)
                            })
                        }
                    }, 500)

                    this.views.loading = false
                })
            },
            clickOnMapScheme(event, mapID) {
                let map

                if(mapID == 1) {
                    map = document.getElementById('wrapper-map')
                }
                if(mapID == 2) {
                    map = document.getElementById('wrapper-map2')
                }

                let x = event.pageX - map.offsetLeft
                let y = event.pageY - map.offsetTop
                
                if(mapID == 1) {
                    this.route_code_floor1.push({x,y})
                }
                if(mapID == 2) {
                    this.route_code_floor2.push({x,y})
                }

                this.renderPath({x,y}, mapID)
            },
            renderPath(obj, mapID) {
                let routeCodeArray

                if(mapID == 1) {
                    routeCodeArray = this.route_code_floor1
                }
                if(mapID == 2) {
                    routeCodeArray = this.route_code_floor2
                }

                let svgNS = "http://www.w3.org/2000/svg"
                let svgItem = document.createElementNS(svgNS, 'svg')
                let circle = document.createElementNS(svgNS, 'circle')

                if(routeCodeArray.length > 1) {
                    let path = document.createElementNS(svgNS,'path')

                    path.setAttribute('class', 'key-anim01')
                    path.setAttribute('fill', 'none')
                    path.setAttribute('stroke-width', '3px')
                    path.setAttribute('stroke', 'rgba(200,10,10,0.5)')

                    path.setAttribute('d', `M${obj.x} ${obj.y}, ${routeCodeArray.slice(-2)[0].x} ${routeCodeArray.slice(-2)[0].y}`)

                    circle.setAttribute('fill', '#f33')
                    circle.setAttribute('cx', obj.x)
                    circle.setAttribute('cy', obj.y)
                    circle.setAttribute('r', 4)
                    
                    svgItem.appendChild(path)
                    svgItem.appendChild(circle)
                } else {
                    circle.setAttribute('fill', '#f33')
                    circle.setAttribute('cx', obj.x)
                    circle.setAttribute('cy', obj.y)
                    circle.setAttribute('r', 4)

                    svgItem.appendChild(circle)
                }

                if(mapID == 1) {
                    document.getElementById('map-path').appendChild(svgItem)
                }
                if(mapID == 2) {
                    document.getElementById('map-path2').appendChild(svgItem)
                }
            },
            undoDotFloor1() {
                let select = document.getElementById('map-path')
                
                if(select.lastChild) {
                    select.removeChild(select.lastChild)
                    this.route_code_floor1.pop()
                }
            },
            undoDotFloor2() {
                let select = document.getElementById('map-path2')
                
                if(select.lastChild) {
                    select.removeChild(select.lastChild)
                    this.route_code_floor2.pop()
                }
            },
            save() {
                if(!this.name) {
                    return this.$swal({
                        text: 'Назовите маршрут',
                        icon: 'error',
                    })
                }

                if(!this.selected.scheme1) {
                    return this.$swal({
                        text: 'Выберите схему',
                        icon: 'error',
                    })
                }

                if(!this.route_code_floor1) {
                    return this.$swal({
                        text: 'Нарисуйте маршрут',
                        icon: 'error',
                    })
                }

                if(this.$route.params.id) {
                    axios.put(`/api/admin/route/${this.$route.params.id}/update`, {
                        kiosk_id: this.selected.kiosk.id,
                        name: this.name,
                        scheme1_id: this.selected.scheme1.id,
                        scheme2_id: this.selected.scheme2.id,
                        floor1_text_begin: this.floor1_text_begin,
                        floor1_text_end: this.floor1_text_end,
                        floor2_text_begin: this.floor2_text_begin,
                        floor2_text_end: this.floor2_text_end,
                        route_code_floor1: this.route_code_floor1,
                        route_code_floor2: this.route_code_floor2
                    })
                    .then(response => (
                        this.$router.push({name: 'Routes', params: {kiosk: 1} })
                    ))
                    .catch((error) => {
                        //
                    })
                } else {
                    axios.post(`/api/admin/routes`, {
                        kiosk_id: this.selected.kiosk.id,
                        name: this.name,
                        scheme1_id: this.selected.scheme1.id,
                        scheme2_id: this.selected.scheme2.id,
                        floor1_text_begin: this.floor1_text_begin,
                        floor1_text_end: this.floor1_text_end,
                        floor2_text_begin: this.floor2_text_begin,
                        floor2_text_end: this.floor2_text_end,
                        route_code_floor1: this.route_code_floor1,
                        route_code_floor2: this.route_code_floor2
                    })
                    .then(response => (
                        this.$router.push({name: 'Routes', params: {kiosk: 1} })
                    ))
                    .catch((error) => {
                        //
                    })
                }
            },
            del() {
                if(confirm('Точно удалить маршрут?')) {
                    axios.delete(`/api/admin/route/${this.$route.params.id}/delete`)
                    .then(response => {
                        this.$router.push({ name: 'Routes', params: {kiosk: 1} })
                    })
                    .catch(errors => {
                        return this.$swal({
                            text: 'Ошибка',
                            icon: 'error',
                        })
                    })
                }
            },
        },
    }
</script>