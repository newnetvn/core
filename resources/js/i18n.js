import Vue from 'vue'
import VueI18n from 'vue-i18n'
import viMessage from './lang/vi.json'
import enMessage from './lang/en.json'

Vue.use(VueI18n);

const messages = {
    vi: viMessage,
    en: enMessage,
};

const i18n = new VueI18n({
    locale: window.locale || 'vi', // set locale
    fallbackLocale: 'vi',
    messages,
});

export default i18n;
