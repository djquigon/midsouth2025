<template>
    <form
        id="location-search-form"
        role="search"
        @submit.prevent="searchByString"
    >
        <ul class="form-fields">
            <li class="form-heading">
                <template v-if="getUserLocationString()">
                    <h2>Search by Your Location:</h2>
                    <h3 v-html="getUserLocationString()"></h3>
                </template>
                <template v-else><h2>Search by Your Location</h2></template>
            </li>
            <li class="find-nearest">
                <button
                    id="find-nearest-location"
                    class="button"
                    type="button"
                    @click="findNearestLocation"
                >
                    Find Nearest
                </button>
                <label for="find-nearest-location">
                    The "Find Nearest" feature requires granting us access to
                    your location.
                </label>
            </li>
            <li class="search-by-string">
                <label for="search-by-string">
                    Search by City & State, or Zip
                </label>
                <input id="search-by-string" type="text" />
                <button id="submit-search" class="button" type="submit">
                    Search
                </button>
                <button
                    id="clear-search"
                    class="button"
                    type="button"
                    @click="clearLocationsSearch"
                >
                    View All
                </button>
            </li>
        </ul>
    </form>
</template>

<script>
import { search_listings } from '../assets/js/search-listings';
import { geolocation } from '../assets/js/geolocation';

export default {
    name: 'SearchForm',
    props: {
        search_term: {
            type: String,
        },
    },
    data() {
        return {
            google: window.google,
            locations: window.the_locations,
        };
    },
    setup() {
        //
    },
    methods: {
        clearLocationsSearch() {
            search_listings.clearLocationsSearch();
        },
        findNearestLocation() {
            search_listings.findNearestLocation();
        },
        getUserLocationString() {
            return geolocation.getUserLocationString();
        },
        searchByString() {
            //there's a conflict with the autocomplete functionality & v-model, so we just use classic javascript to pass the text box's value to the search function:
            search_listings.searchByString(
                document.getElementById('search-by-string').value
            );
        },
    },
    async mounted() {
        //This lifecycle hook is called after the component has been mounted to the DOM. It indicates that the component's template has been rendered and inserted into the document. It is commonly used for tasks that require access to the DOM, such as interacting with external libraries or manipulating elements directly.

        //import the Google Places API so that we can use it in our text search functions, but push it to a state object so we only have to import it once:
        search_listings.state.places_API =
            await google.maps.importLibrary('places');

        //initialize Google Autocomplete for search form text box:
        search_listings.initializeGoogleAutocomplete();

        //if we've been passed a search term, trigger the search function as soon as everything else is ready:
        if (this.search_term.length > 0) {
            //apply the search term string to the form's text input value:
            document.getElementById('search-by-string').value =
                this.search_term;

            //call the search function:
            search_listings.searchByString(
                document.getElementById('search-by-string').value
            );
        }
    },
};
</script>
