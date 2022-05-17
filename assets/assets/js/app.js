require('../css/app.scss');

import { createApp } from 'vue'
import { createI18n } from 'vue-i18n'
const i18n = createI18n({
    locale: 'fr'
});

import axios from 'axios'
import VueAxios from 'vue-axios'
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';
import BadgeDirective from 'primevue/badgedirective';
import Tooltip from 'primevue/tooltip';

import App from './app/App';
import moment from "moment";

const app = createApp(App);
app.directive('badge', BadgeDirective);
app.directive('tooltip', Tooltip);

if (document.getElementById('app')) {
    app.use(VueAxios, axios);

    axios.all([
        axios.get('/translation')
    ])
    .then((response) => {
        app.use(PrimeVue,{
            locale: {
                startsWith: 'Starts with',
                contains: 'Contains',
                notContains: 'Not contains',
                endsWith: 'Ends with',
                equals: 'Equals',
                notEquals: 'Not equals',
                noFilter: 'No Filter',
                lt: 'Less than',
                lte: 'Less than or equal to',
                gt: 'Greater than',
                gte: 'Greater than or equal to',
                dateIs: 'Date is',
                dateIsNot: 'Date is not',
                dateBefore: 'Date is before',
                dateAfter: 'Date is after',
                clear: 'Clear',
                apply: 'Apply',
                matchAll: 'Match All',
                matchAny: 'Match Any',
                addRule: 'Add Rule',
                removeRule: 'Remove Rule',
                accept: 'Yes',
                reject: 'No',
                choose: 'Choose',
                upload: 'Upload',
                cancel: 'Cancel',
                dayNames: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"],
                dayNamesShort: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"],
                dayNamesMin: ["Di","Lu","Ma","Me","Je","Ve","Sa"],
                monthNames: ["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"],
                monthNamesShort: ["Jan", "Fev", "Mar", "Avr", "Mai", "Jui","Juil", "Août", "Sep", "Oct", "Nov", "Dec"],
                today: 'Aujourd\'hui',
                weekHeader: 'Semaine',
                firstDayOfWeek: 0,
                dateFormat: 'dd/mm/yy',
                weak: 'Weak',
                medium: 'Medium',
                strong: 'Strong',
                passwordPrompt: 'Enter a password',
                emptyFilterMessage: 'No results found',
                emptyMessage: 'No available options'
            }
        });

        app.use(ToastService);


        const translations = response[0].data;

        app.config.globalProperties.$filters = {
            formatDate: function (value, format) {
                return moment(value).format(format);
            },
            translate: function (text) {
                for (let i in translations) {
                    for (let j in translations[i]) {
                        if (j === text) {
                            return translations[i][j];
                        }
                    }
                }

                return text;
            }
        };

        app.mount('#app');
    });
}
