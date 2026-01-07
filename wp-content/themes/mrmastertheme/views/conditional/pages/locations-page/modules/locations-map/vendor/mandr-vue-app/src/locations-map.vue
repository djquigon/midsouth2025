<template>
    <div class="content-row">
        <div class="columns">
            <div class="column one-third">
                <SearchForm :search_term="getSearchTerm" />
                <LocationListings
                    :active_listings="getActiveListings"
                    :is_search_results_empty="getSearchResultsStatus"
                />
            </div>
            <div class="column two-thirds">
                <GoogleMap />
            </div>
        </div>
        <span
            class="row-settings"
            data-column-count="two"
            data-column-width="variable"
            data-column-gap="none"
        >
            <span class="validator-text" data-nosnippet="">row settings</span>
        </span>
    </div>
</template>

<script>
//import { watch } from 'vue';
import GoogleMap from './components/GoogleMap';
import SearchForm from './components/SearchForm';
import LocationListings from './components/LocationListings';

import { search_listings } from './assets/js/search-listings';

export default {
    name: 'LocationsMap',
    components: {
        GoogleMap,
        SearchForm,
        LocationListings,
    },
    data() {
        return {
            //google: window.google,
            //locations: window.the_locations,
        };
    },
    setup() {
        //

        return {};
    },
    methods: {
        //this is a place to declare any functions, but be mindful of the scope of those functions. If it's a function that needs to be accessed by a separate .vue component, consider moving it elsewhere.
        //
    },
    computed: {
        //These (computed properties) are used to derive values from existing data. They are reactive, meaning they automatically update when their dependencies change. Computed properties are defined as functions within the computed option and are accessed as properties in templates and component methods. They are ideal for calculations or data transformations that need to be dynamically updated.

        getActiveListings() {
            //grab the active listings from the state object & pass it as a vue prop to the right component file:
            return search_listings.state.all_active_listings;
        },
        getSearchResultsStatus() {
            //this object property (boolean) controls the visibility of the 'No Results' message in the listings window
            return search_listings.state.is_search_results_empty;
        },
        getSearchTerm() {
            //pass the search term as a vue prop to the right component file. This search term is retrieved by a function in the callbacks.php file
            return window.search_term;
        },
    },
    created() {
        //This lifecycle hook is called after the component instance has been created and initialized, but before the DOM is rendered. It is suitable for tasks that need to be performed before the component is displayed, such as fetching data, initializing variables, or setting up event listeners.
        //
    },
    async mounted() {
        //This lifecycle hook is called after the component has been mounted to the DOM. It indicates that the component's template has been rendered and inserted into the document. It is commonly used for tasks that require access to the DOM, such as interacting with external libraries or manipulating elements directly.
        //
    },
};
</script>
