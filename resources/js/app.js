import {createApp, h} from 'vue'
import {createStore} from 'vuex'
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import {createInertiaApp} from '@inertiajs/vue3'
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import '../css/app.css';
import 'flowbite';
import './bootstrap.js';

import.meta.glob([// '../images/**',
    '../fonts/**']);
const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';
const store = createStore({
    state() {
        return {
            language: {
                langName: '', langInfo: {}, core: {},
            },
        }
    }, mutations: {
        setLang(state, lang) {

            state.language.core = lang.lang;
            state.language.langInfo = lang.langInfo;
        }, setLangName(state, langName) {
            state.language.langName = langName;
        },

    }
})
let temp = {};
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({el, App, props, plugin}) {
        // setlang(props);
        const langsFromInertia = props.initialPage.props.langs;
        store.commit('setLangName', langsFromInertia.site_locale);
        store.commit('setLang', langsFromInertia[store.state.language.langName]);//what is the another way?
        return createApp({render: () => h(App, props)})
            .use(plugin)
            .use(store)
            .use(VueSweetalert2)
            .mixin({methods: {route}})
            .mount(el);
    },
});
