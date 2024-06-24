import './bootstrap';

import { createApp } from 'vue';

const app = createApp({});

import ContactForm from '../src/ContactForm.vue';
app.component('contact-form', ContactForm);

app.mount('#app');