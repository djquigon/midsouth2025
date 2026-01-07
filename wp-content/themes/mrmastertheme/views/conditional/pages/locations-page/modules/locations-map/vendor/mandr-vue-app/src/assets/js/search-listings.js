import { reactive } from 'vue';
import { geolocation } from './geolocation';
import { map_manipulation } from './map-manipulation';

const state = reactive({
    google: window.google,
    places_API: '',
    all_listings: [], 
    all_active_listings: [], 
    coordinates_returned_via_search_string:[],
    is_search_results_empty: false
}); 

const clearActiveListings = () => {
    state.all_active_listings = [];
}

const clearLocationsSearch = () => {
    //this function is triggered by the 'View All' button

    //close all infowindows
    map_manipulation.closeAllInfoWindows();

    //clear all active listings
    clearActiveListings();

    //reset the boolean that controls the 'no results' message:
    state.is_search_results_empty = false;

    //reset the search text box value
    document.getElementById('search-by-string').value = '';

    //set active listings equal to all listings array
    state.all_active_listings = state.all_listings;

    //"deactivate" all listings:
    deactivateAllListings();

    //reset all markers icons:
    map_manipulation.resetAllMarkerIcons();

    //toggle-on the visibility of all markers
    map_manipulation.showAllMarkers();

    //reset map bounds & re-center
    map_manipulation.centerMapAtDefaultPosition(map_manipulation.state.active_map);
} 

const deactivateAllListings = () => {
    //grab all the listing <li>(s)
    var listings = document.getElementsByClassName('location-listing');

    //loop through them and toggle the data-attribute that controls the 'active' styling:
    for (let i = 0; i < listings.length; i++) {
        listings[i].setAttribute("data-active", "false");
    }
}

const getCoordinatesFromSearchString = async (search_string) => {
    //first, use some regex to check if the search string is a zip code:
    if (/^\d{5}(-\d{4})?$/.test(search_string)) {
        //if so, we pass this type to the Places API function
        var includedType = 'postal_code';
    } else {
        //all other string searches are looking for this type:
        var includedType = 'locality';
    }

    //set up the request arguments:
    const request = {
        textQuery: search_string,
        fields: ["displayName","location"],
        includedType: includedType,
        useStrictTypeFiltering: true,
        language: "en-US",
        maxResultCount: 1,
    };
    
    try { 
        //Google Places API is imported in SearchForm.vue & pushed to the state object so we can use it's functions:        
        const { places } = await state.places_API.Place.searchByText(request);

        var coordinates = '';

        for (let i = 0; i < places.length; i++) {
            //the 'Eg' is a weird reference point, but that's where the location coordinates are buried in the object:
            coordinates = places[i].Eg.location;
            break;
        } 
        
        //push the coordinates to the state object for future reference:
        state.coordinates_returned_via_search_string = coordinates; 

        return;
    } catch {
        alert('Something went wrong with your search');
    }
}

const getListingsInSearchRadius = (coordinates, radius_in_miles) => {
    //loop through each listing
    for (let i = 0; i < state.all_listings.length; i++) {
        
        //grab the listing's Latitude & Longitude
        const listing_latitude = state.all_listings[i].latitude;
        const listing_longitude = state.all_listings[i].longitude;

        //use a function we lifted from stackoverflow to compare distance between listing & the searched location coordinates:
        const distance_from_searched_location = geolocation.haversineDistance(
            [coordinates.lat, coordinates.lng],
            [listing_latitude, listing_longitude]
        ).toFixed(2);

        //push that distance to the listing object
        state.all_listings[i].distance_from_searched_location = distance_from_searched_location;

        //if the listing is within the set radius, push it to the active listings array:
        if (state.all_listings[i].distance_from_searched_location <= radius_in_miles) {
            state.all_active_listings.push(state.all_listings[i]);
        }
    }
}

const findNearestLocation = async () => {
    //because we're using 'await' & promises, we need to nest everything in a try/catch so that we can make things happen sequentially:
    try {
        //use the functions in geolocation.js to grab the user's current position, but wait for this to resolve before proceeding with the rest of our current function. Everything is contingent on having the user's geolocation:
        await new Promise((resolve, reject) => { 
            resolve(geolocation.getUserGeoLocation());
        }); 

        //close any open infoWindows:
        map_manipulation.closeAllInfoWindows();

        //reset marker icons
        map_manipulation.resetAllMarkerIcons();

        
            
        //re-position the map to be  centered on the user's current position: 
        map_manipulation.centerMapAroundLocation(geolocation.state.user_geolocation);

        //deactivate all listings:
        deactivateAllListings();

        //clear all current listings:
        clearActiveListings();

        //loop through locations to put them all back in the order of proximity to the user:
        await orderListingsByProximity(state.all_listings, geolocation.state.user_geolocation);
        
        //open the infoWindow of the nearest marker:
        map_manipulation.openNearestInfoWindow();

        //grab the nearest location's place_id, use it to loop through all the markers and find the correct one to toggle:
        var nearest_marker_place_id = state.all_active_listings[0].place_id;
        for (let i = 0; i < map_manipulation.state.all_markers.length; i++) {
            if (map_manipulation.state.all_markers[i].place_id === nearest_marker_place_id) {
                var nearest_marker = map_manipulation.state.all_markers[i];
                break;
            }
        }        
        
        //toggle the active state of the nearest location's marker:
        map_manipulation.activateMarkerIcon(nearest_marker);

        //declare variable to hold the nearest listing HTML,  (by this point, it's the 1st <li> of ul#location-listings):
        var nearest_listing = document.getElementById('location-listings').firstElementChild;

        //toggle the active state of nearest listing:
        nearest_listing.setAttribute('data-active','true');

        document.getElementById('location-listings').scrollTo({
            top: nearest_listing.offsetTop,
            left: 0,
            behavior: 'smooth',
        });
    } catch (error) {
        alert(error);
    }
} 

const initializeLocationListings = (locations) => {
    for (let i = 0; i < locations.length; i++) {
        //push each location to the state object for future reference:
        state.all_listings.push(locations[i]);

        //this will change eventually when we add pre-filtered search functionality, but for now, consider each location as 'active' on the initialization
        state.all_active_listings.push(locations[i]);
    }
}

const initializeGoogleAutocomplete = () => {
    //target the search form's text box:
    const input = document.getElementById('search-by-string');

    //we only want US city name & state
    const options = {
        componentRestrictions: { country: ['us'] },
        types: ['(cities)'],
        fields: ['address_components'],
    };

    //initialize the autocomplete object:
    const autocomplete = new google.maps.places.Autocomplete(
        input,
        options
    );
}

const orderListingsByProximity = (listings, geolocation_object) => {
        
    //loop through each listing
    for (let i = 0; i < listings.length; i++) {
        
        //grab the listing's Latitude & Longitude
        const listing_latitude = listings[i].latitude;
        const listing_longitude = listings[i].longitude;

        //use a function we lifted from stackoverflow to compare distance between listing & user:
        const distance_from_user = geolocation.haversineDistance(
            [geolocation_object.coords.latitude, geolocation_object.coords.longitude],
            [listing_latitude, listing_longitude]
        ).toFixed(2);

        //push that distance to the listing object
        listings[i].distance_from_user = distance_from_user;

        //push the listing back into the active listings state object:
        state.all_active_listings.push(listings[i]);
    }

    //sort the active listings by the distance values we now have:
    state.all_active_listings = state.all_active_listings.sort(sortByDistanceFromUser);
}

const searchByString = async (search_string) => {
    if (search_string.length > 0) {
        try {
            //close all infoWindows, clear active listings, reset & show all markers, clear the coordinates from any previous searches, reset the search results booleans
            clearActiveListings();
            map_manipulation.closeAllInfoWindows(); 
            map_manipulation.resetAllMarkerIcons();       
            map_manipulation.showAllMarkers();
            state.coordinates_returned_via_search_string = [];
            state.no_results = false;
            state.is_search_results_empty = false;

            //take the user's search input & use the Google Places API to associate it with a set of coordinates:
            await getCoordinatesFromSearchString(search_string);

            //calculate a 25 mile radius around that location, loop through all map listings and markers to determine which are valid results. 25 can be swapped out for a different number here.
            getListingsInSearchRadius(state.coordinates_returned_via_search_string, 25);
            map_manipulation.getMarkersInSearchRadius(state.coordinates_returned_via_search_string, 25);
            
            //sort results by proximity to geolocation, open infowindow of closest location
            state.all_active_listings = state.all_active_listings.sort(sortByDistanceFromSearchString);

            //center map around the coordinates we get from our search string:
            if (state.coordinates_returned_via_search_string) {
                map_manipulation.state.active_map.setCenter(state.coordinates_returned_via_search_string);
            } else {
                map_manipulation.centerMapAtDefaultPosition;
            }                 

            //check the length of the search results array, & if it's 0, change the state object boolean that displays the 'no results' message:
            if (state.all_active_listings.length === 0) {
                state.is_search_results_empty = true;
            } 
        } catch {
            alert('Something went wrong with your search'); 
        }
    }
}

const sortByDistanceFromSearchString = (a, b) => {
    //distance_from_user is calculated in orderListingsByProximity()
    return a.distance_from_searched_location - b.distance_from_searched_location;
}

const sortByDistanceFromUser = (a, b) => {
    //distance_from_user is calculated in orderListingsByProximity()
    return a.distance_from_user - b.distance_from_user;
}

const toggleActiveListing = (wp_id, scroll = true) => {
    //We use the wp_id as the identifier, because it seems like the safest option. I can imagine a scenario that a location doesn't have a place_id associated with it. 

    //grab the <li> & toggle it's active state to true, triggering a styling change for UX:
    var active_listing = document.querySelector('[data-wp-id="'+wp_id+'"]');
    active_listing.setAttribute('data-active', 'true');

    //force the <ul> to scroll the active <li> into view:
    if (scroll) {
        document.getElementById('location-listings').scrollTo({
            top: active_listing.offsetTop,
            left: 0,
            behavior: 'smooth',
        });
    }
};

export const search_listings = {
    state,
    clearActiveListings,
    clearLocationsSearch,
    deactivateAllListings,
    findNearestLocation,
    initializeGoogleAutocomplete,
    initializeLocationListings,
    searchByString,
    toggleActiveListing
};