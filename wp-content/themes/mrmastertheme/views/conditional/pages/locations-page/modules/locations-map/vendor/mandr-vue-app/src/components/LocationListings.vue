<template>
    <ul id="location-listings">
        <li
            v-for="listing in active_listings"
            class="location-listing"
            :key="listing.wp_id"
            :data-wp-id="listing.wp_id"
            :data-place-id="listing.place_id"
            data-active="false"
        >
            <h3 class="listing-name">
                <button
                    class="toggle-trigger"
                    aria-expanded="false"
                    :aria-controls="`listing-info-toggle-${listing.wp_id}`"
                    @click="toggleListingInfo"
                >
                    {{ listing.name }}
                </button>
            </h3>
            <ul
                class="listing-info-toggle"
                :id="`listing-info-toggle-${listing.wp_id}`"
                aria-hidden="true"
            >
                <li v-if="listing.place_id" class="address">
                    Address:
                    <a
                        :href="`https://www.google.com/maps/place/?q=place_id:${listing.place_id}`"
                        target="_blank"
                        >{{ listing.address }}</a
                    >
                </li>
                <li v-if="listing.phone" class="phone">
                    Phone:
                    <a :href="`tel:${listing.phone}`">{{ listing.phone }}</a>
                </li>
                <li v-if="listing.email" class="email">
                    Email:
                    <a :href="`mailto:${listing.email}`">{{ listing.email }}</a>
                </li>
                <li v-if="listing.hours" class="hours">
                    <span class="label">Hours:</span>
                    <span v-html="`${listing.hours}`"></span>
                </li>
                <li v-if="listing.website" class="website">
                    <a :href="`${listing.website}`" target="_blank"
                        >View Website</a
                    >
                </li>
            </ul>
            <span class="directions-button">
                <a
                    :href="`https://www.google.com/maps/place/?q=place_id:${listing.place_id}`"
                    target="_blank"
                >
                    Get Directions
                </a>
            </span>
            <span v-if="listing.wp_link" class="single-view-button">
                <a :href="`${listing.wp_link}`"> View Location </a>
            </span>
        </li>
        <template v-if="is_search_results_empty">
            <li class="no-results">
                <h3>No results to display</h3>
            </li>
        </template>
    </ul>
</template>

<script>
import { search_listings } from '../assets/js/search-listings';
import { map_manipulation } from '../assets/js/map-manipulation';

export default {
    name: 'LocationListings',
    props: {
        active_listings: {
            type: Object,
        },
        is_search_results_empty: {
            type: Boolean,
        },
    },
    data() {
        return {
            google: window.google,
            locations: window.the_locations,
        };
    },
    methods: {
        toggleListingInfo(e) {
            //toggle the aria-expanded attribute of the button
            if (e.target.ariaExpanded === 'false') {
                e.target.ariaExpanded = 'true';

                //if we're 'opening' the toggle, we also want to open the associated infoWindow:
                map_manipulation.openInfoWindowFromListingToggle(e);
            } else {
                e.target.ariaExpanded = 'false';
            }

            //grab the ID of the <span> that the <button> toggles
            var toggle_trigger_target_ID = e.target.attributes[2].value;

            //use the ID to grab the element
            var toggle_info_span = document.getElementById(
                toggle_trigger_target_ID
            );

            //toggle the aria-hidden attribute of the listing info <span>
            if (toggle_info_span.getAttribute('aria-hidden') === 'true') {
                toggle_info_span.setAttribute('aria-hidden', 'false');
            } else {
                toggle_info_span.setAttribute('aria-hidden', 'true');
            }
        },
    },
    async mounted() {
        //This lifecycle hook is called after the component has been mounted to the DOM. It indicates that the component's template has been rendered and inserted into the document. It is commonly used for tasks that require access to the DOM, such as interacting with external libraries or manipulating elements directly.

        //Initialize the Location Listings buy looping through the location PHP data
        search_listings.initializeLocationListings(this.locations);
    },
};
</script>
