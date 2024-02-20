import { createApp } from "vue";
import App from "./App.vue";

import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap";

import "../src/assets/css/adminlte.min.css";
import "../src/assets/js/adminlte.min.js";

import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";

const app = createApp(App);

app.component("VueDatePicker", VueDatePicker);
app.use(VueSweetalert2);

app.mount("#app");
