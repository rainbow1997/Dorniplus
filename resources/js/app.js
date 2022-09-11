import {createApp, h} from 'vue'
import {createInertiaApp} from '@inertiajs/inertia-vue3'
import {InertiaProgress} from '@inertiajs/progress'
import 'flowbite';


const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';
window.$ = window.jQuery = require('jquery');
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({el, app, props, plugin}) {
        return createApp({render: () => h(app, props)})
            .use(plugin)
            .mixin({methods: {route}})
            .mount(el);
    },
});
window.document.body.setAttribute('dir', 'rtl');

InertiaProgress.init({color: '#4B5563'});
