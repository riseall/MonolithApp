import './bootstrap';
import '../css/app.css';

import { createApp, h, DefineComponent } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faArrowRightFromBracket, faArrowRightToBracket, faBook, faBriefcase, faBuilding, faCalendarDays, faCameraRetro, faChevronLeft, faChevronRight, faClipboard, faClockRotateLeft, faFilePdf, faGear, faHouseChimney, faMapLocationDot, faShieldHalved, faUser, faUserTie, faUsers} from '@fortawesome/free-solid-svg-icons'
library.add(faHouseChimney, faUsers, faChevronRight, faChevronLeft, faBuilding, faBriefcase, faClipboard, faBook, faUserTie, faUser, faShieldHalved, faMapLocationDot, faClockRotateLeft, faUser, faCameraRetro, faArrowRightToBracket, faArrowRightFromBracket, faCalendarDays, faGear, faFilePdf)
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
const appName = import.meta.env.VITE_APP_NAME || 'Internship Monitor';

createInertiaApp({
    title: (title) => `${title}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .component('font-awesome-icon', FontAwesomeIcon)
            .component('VueDatePicker', VueDatePicker)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
