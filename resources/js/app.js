import {createApp, h} from 'vue'
import {createInertiaApp} from '@inertiajs/inertia-vue3'
import {InertiaProgress} from '@inertiajs/progress'
import {createStore} from 'vuex'

import 'flowbite';


const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';
window.$ = window.jQuery = require('jquery');
const store = createStore({
    state() {
        return {
            language: {
                langName: '',
                langInfo: {},
                core: {},
            },
        }
    },
    mutations: {
        setLang(state, lang) {
            state.language.core = lang.lang;
            state.language.langInfo = lang.langInfo;
        }
        ,
        setLangName(state, langName) {
            state.language.langName = langName;
        },

    }
})
let temp = {};
const app = createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({el, app, props, plugin}) {
        const langsFromInertia = props.initialPage.props.langs;
        store.commit('setLangName', langsFromInertia.site_locale);
        store.commit('setLang', langsFromInertia[store.state.language.langName]);//what is the another way?

        return createApp({render: () => h(app, props)})
            .use(plugin)
            .use(store)
            .mixin({methods: {route}})
            .mount(el);
    },
});
//store.commit('setLangs','fa_IR');

InertiaProgress.init({color: '#4B5563'});
console.log(store.state.language.langInfo.direction);
