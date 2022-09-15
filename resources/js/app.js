import {createApp, h} from 'vue'
import {createInertiaApp} from '@inertiajs/inertia-vue3'
import {InertiaProgress} from '@inertiajs/progress'
import { createStore } from 'vuex'
import { usePage } from '@inertiajs/inertia-vue3'

import 'flowbite';


const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';
window.$ = window.jQuery = require('jquery');
const store = createStore({
    state () {
        return {
            count: 0,
            lang:{}
        }
    },
    mutations: {
        increment (state) {
            state.count++
        },
        setLang(state,lang)
        {
            state.lang = lang
        }
    }
})

let temp = {};
const app = createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({el, app, props, plugin}) {
       store.commit('setLang',props.initialPage.props.langs[props.initialPage.props.langs.site_locale]);//what is the another way?
        return createApp({render: () => h(app, props)})
            .use(plugin)
            .use(store)
            .mixin({methods: {route}})
            .mount(el);
    },
});
//store.commit('setLangs','fa');
window.document.body.setAttribute('dir', 'rtl');

InertiaProgress.init({color: '#4B5563'});
