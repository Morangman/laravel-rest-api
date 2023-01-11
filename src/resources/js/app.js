import './bootstrap';

import { createApp } from 'vue';

import router from './router/index.js';
import App from './components/App.vue';
import JsonViewer from "vue3-json-viewer";
import "vue3-json-viewer/dist/index.css";

const app = createApp(App);

app.use(router);
app.use(JsonViewer);

app.mount('#app');