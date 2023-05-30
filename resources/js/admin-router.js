import { createRouter, createWebHistory } from 'vue-router'

import Home from './components/admin/Home.vue'

import Pages from './components/admin/pages/Index.vue'
import Page from './components/admin/pages/Page.vue'
import PageMaster from './components/admin/pages/Master.vue'

import Kiosks from './components/admin/kiosks/Index.vue'
import KioskMaster from './components/admin/kiosks/Master.vue'

import Schemes from './components/admin/schemes/Index.vue'
import SchemeMaster from './components/admin/schemes/Master.vue'

import Routes from './components/admin/routes/Index.vue'
import RouteMaster from './components/admin/routes/Master.vue'

import Banners from './components/admin/banners/Index.vue'
import BannerMaster from './components/admin/banners/Master.vue'

import Screensavers from './components/admin/screensavers/Index.vue'
import ScreensaverMaster from './components/admin/screensavers/Master.vue'

import Events from './components/admin/events/Index.vue'
import EventMaster from './components/admin/events/Master.vue'

import Config from './components/admin/config/Edit.vue'

const routes = [
    {
        path: '/admin',
        name: 'Home',
        component: Home
    },
    {
        path: '/admin/pages',
        name: 'Pages',
        component: Pages
    },
    {
        path: '/admin/page/:id',
        name: 'Page',
        component: Page
    },
    {
        path: '/admin/page-master/:id?',
        name: 'PageMaster',
        component: PageMaster,
        props: route => ({ query: route.query })
    },
    {
        path: '/admin/kiosks',
        name: 'Kiosks',
        component: Kiosks
    },
    {
        path: '/admin/kiosk-master/:id?',
        name: 'KioskMaster',
        component: KioskMaster
    },
    {
        path: '/admin/schemes',
        name: 'Schemes',
        component: Schemes
    },
    {
        path: '/admin/scheme-master/:id?',
        name: 'SchemeMaster',
        component: SchemeMaster
    },
    {
        path: '/admin/routes/:kiosk',
        name: 'Routes',
        component: Routes
    },
    {
        path: '/admin/route-master/:id?',
        name: 'RouteMaster',
        component: RouteMaster
    },
    {
        path: '/admin/banners',
        name: 'Banners',
        component: Banners
    },
    {
        path: '/admin/banner-master/:id?',
        name: 'BannerMaster',
        component: BannerMaster
    },
    {
        path: '/admin/screensavers',
        name: 'Screensavers',
        component: Screensavers
    },
    {
        path: '/admin/screensaver-master/:id?',
        name: 'ScreensaverMaster',
        component: ScreensaverMaster
    },
    {
        path: '/admin/events',
        name: 'Events',
        component: Events
    },
    {
        path: '/admin/event-master/:id?',
        name: 'EventMaster',
        component: EventMaster
    },
    {
        path: '/admin/config',
        name: 'Config',
        component: Config
    },
];

export default createRouter({
    history: createWebHistory(),
    routes
})