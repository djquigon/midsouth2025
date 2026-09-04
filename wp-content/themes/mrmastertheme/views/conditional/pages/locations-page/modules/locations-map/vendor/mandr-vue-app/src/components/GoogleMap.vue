<template>
    <div id="map">
        <!-- Google Map will be inserted dynamically -->
    </div>
</template>

<script>
import { map_initialization } from '../assets/js/map-initialization';

export default {
    name: 'GoogleMap',
    data() {
        return {
            google: window.google,
            locations: window.the_locations,
        };
    },
    async mounted() {
        //This lifecycle hook is called after the component has been mounted to the DOM. It indicates that the component's template has been rendered and inserted into the document. It is commonly used for tasks that require access to the DOM, such as interacting with external libraries or manipulating elements directly.

        //import the libraries that we need from Google:
        const { Map } = await google.maps.importLibrary('maps');
        const { AdvancedMarkerElement } =
            await google.maps.importLibrary('marker');
        const { LatLngBounds } = await google.maps.importLibrary('core');

        //run the function that initializes the map, markers, & infoWindows:
        map_initialization.initializeMap(this.locations);
    },
};
</script>
