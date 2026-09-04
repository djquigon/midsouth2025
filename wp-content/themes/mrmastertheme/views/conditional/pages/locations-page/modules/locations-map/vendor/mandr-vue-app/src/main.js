import { createApp } from "vue"; 
import locations_map from "./locations-map.vue";
 
if (document.getElementById('locations-map')){
    createApp(locations_map).mount("#locations-map");
} 