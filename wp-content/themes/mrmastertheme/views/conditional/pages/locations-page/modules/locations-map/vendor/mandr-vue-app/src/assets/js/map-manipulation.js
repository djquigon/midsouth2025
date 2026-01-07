import { reactive } from 'vue';
import { geolocation } from './geolocation';
import { map_initialization } from './map-initialization';
import { search_listings } from './search-listings';

const state = reactive({
    google: window.google,
    active_map: '',
    all_markers: [], 
    all_info_windows: [],
}); 

const activateMarkerIcon = (marker) => {
    //we pass a marker to this function as a parameter so that we can use it as a reference point. The marker's 'icon' is a child node HTML element <img>

    //all of the URL & sizing info we need is written into the marker's icon <img> HTML as data-attributes at the point we initialize them in map-initialization.initializeMarkersAndInfoWindows(). This means that all we need to do is grab the element & use setAttribute() appropriately:
    var icon_active_url = marker.childNodes[0].getAttribute('data-icon-active-url');
    var icon_active_width = marker.childNodes[0].getAttribute('data-icon-active-width');
    var icon_active_height = marker.childNodes[0].getAttribute('data-icon-active-height');    
    
    marker.childNodes[0].setAttribute('src', icon_active_url);
    marker.childNodes[0].setAttribute('width', icon_active_width);
    marker.childNodes[0].setAttribute('height', icon_active_height);
}

const centerMapAroundLocation = async (geolocation_object) => {
    //a geolocation object is used to extract Lat & Lng coordinates, which are then passed to the Google Maps API function that resets the map's center position:

    var coordinates = {
        lat: geolocation_object.coords.latitude,
        lng: geolocation_object.coords.longitude,         
    };
    
    state.active_map.setCenter(coordinates); 
}

const centerMapAtDefaultPosition = (map) => {
    //at initialization, we establish the default bounds. So really all we need to do is call the function that fits the map to it
    map.fitBounds(map_initialization.state.map_bounds);
}

const closeAllInfoWindows = () => {
    //loop through all infoWindows in state object & close them
    for (let i = 0; i < state.all_info_windows.length; i++) {
        state.all_info_windows[i].close();
    }    
}

const getMarkersInSearchRadius = (coordinates, radius_in_miles) => {
    //loop through each marker
    for (let i = 0; i < state.all_markers.length; i++) {        
        //grab the listing's Latitude & Longitude
        const marker_latitude = state.all_markers[i].position.lat;
        const marker_longitude = state.all_markers[i].position.lng;

        //use a function we lifted from stackoverflow to compare distance between listing & the searched location coordinates:
        const distance_from_searched_location = geolocation.haversineDistance(
            [coordinates.lat, coordinates.lng],
            [marker_latitude, marker_longitude]
        ).toFixed(2);

        
        //push that distance to the marker object
        state.all_markers[i].distance_from_searched_location = distance_from_searched_location;

        //if the listing is NOT within the set radius, hide it:
        if (state.all_markers[i].distance_from_searched_location > radius_in_miles) {
            state.all_markers[i].hidden = true;
        }
    }
}

const hideAllMarkers = () => {
    //loop through the all_markers state object(array)
    for (let i = 0; i < state.all_markers.length; i++) {
        //if a marker's hidden setting is set to false, reverse that:
        if (state.all_markers[i].hidden === false) {
            state.all_markers[i].hidden = true;
        }
    }
}

const markerClickEvent = (marker, info_window, location, map) => {
    //dictate whatever needs to happen when a marker is clicked: close all other infoWindows, open its own infoWindow, change the icon, toggle the active state of the associated listing, etc.
    marker.addListener("gmp-click", () => {
        //close all other infoWindows
        closeAllInfoWindows();

        //reset all marker icons to default:
        resetAllMarkerIcons();

        //open the corresponding infoWindow
        info_window.open({
            anchor: marker,
            map,
        });

        //toggle THIS marker's icon to the active state:
        activateMarkerIcon(marker);

        //"deactivate" all listings:
        search_listings.deactivateAllListings();

        //toggle the active state of the corresponding location listing, using the location's wp_id property as an identifier. 2nd parameter forces listing to scroll to top of list 
        search_listings.toggleActiveListing(location.wp_id,true);
    });
};

const openInfoWindowFromListingToggle = (e) => {
    //This function is triggered by the click event of a listing's toggle. We're passing the click event (e) of the toggle button to this function as a parameter

    //first, close all other infoWindows, deactivate other listings, & reset marker icons:
    closeAllInfoWindows();
    search_listings.deactivateAllListings();
    resetAllMarkerIcons();

    //go 2 parent nodes up to the <li>
    var parent_listing = e.target.parentNode.parentNode;
    
    //set it as active:
    parent_listing.setAttribute('data-active', 'true');

    //grab it's place_id:
    var parent_listing_place_id =
        parent_listing.getAttribute('data-place-id');

    //loop through all the markers, grab the correct one to use as an anchor for the infoWindow:
    for (let i = 0; i < state.all_markers.length; i++) {
        if (state.all_markers[i].place_id === parent_listing_place_id) {
            var marker = state.all_markers[i];
            break;
        }
    }

    //change the marker's icon to the 'active' state:
    activateMarkerIcon(marker);

    //loop through the infoWindows, use the place_id to find the correct infoWindow & open it:
    for (let i = 0; i < state.all_info_windows.length; i++) {
        if (state.all_info_windows[i].content.includes(parent_listing_place_id)) {
            state.all_info_windows[i].open({
                anchor: marker,
                map,
            });
            break;
        }
    }
}

const openNearestInfoWindow = () => {
    //this function is called by search_listings.findNearestLocation() in search-listings.js
    //by the time it's called we've sorted the listings by proximity to the user. So, all we really need to do is grab the 1st listing in the array & open the correct infoWindow:
    const closest_listing = search_listings.state.all_active_listings[0];

    //we'll grab the listing's place_id & use it to associate the correct infowindow with it:
    const closest_listing_place_id = closest_listing.place_id;

    //loop through the markers in the state object to find the closest marker
    for (let i = 0; i < state.all_markers.length; i++) {
        if (state.all_markers[i].place_id === closest_listing_place_id) {
            var closest_marker = state.all_markers[i];
            break;
        }
    }

    //declare the map variable so that we can pass it to the infoWindow open() function:
    var map = state.active_map;

    //loop through the infowindows in the state object:
    for (let i = 0; i < state.all_info_windows.length; i++) {
        //check the infowindow's content, & if the place_id exists in the string, open the infowindow:
        if (state.all_info_windows[i].content.indexOf(closest_listing_place_id.toString()) > -1) {
            state.all_info_windows[i].open({
                anchor: closest_marker,
                map,
            });
            break;
        }
    }
}

const resetAllMarkerIcons = () => {
    //loop through all markers:
    for (let i = 0; i < state.all_markers.length; i++) {
        //all of the URL & sizing info we need is written into the marker's icon <img> HTML as data-attributes at the point we initialize them in map-initialization.initializeMarkersAndInfoWindows(). This means that all we need to do is grab the element & use setAttribute() appropriately:
        var marker_icon_element = state.all_markers[i].childNodes[0];

        var icon_default_url = marker_icon_element.getAttribute('data-icon-default-url');
        var icon_default_width = marker_icon_element.getAttribute('data-icon-default-width');
        var icon_default_height = marker_icon_element.getAttribute('data-icon-default-height');

        marker_icon_element.setAttribute('src', icon_default_url);
        marker_icon_element.setAttribute('width', icon_default_width);
        marker_icon_element.setAttribute('height', icon_default_height);
    }
}

const showAllMarkers = () => {
    //loop through the all_markers state object(array)
    for (let i = 0; i < state.all_markers.length; i++) {
        //if a marker's hidden setting is set to true, reverse that:
        if (state.all_markers[i].hidden === true) {
            state.all_markers[i].hidden = false;
        }
    }
}

export const map_manipulation = {
    state,
    activateMarkerIcon,
    centerMapAroundLocation,
    centerMapAtDefaultPosition,
    closeAllInfoWindows,
    getMarkersInSearchRadius,
    hideAllMarkers,
    markerClickEvent,
    openInfoWindowFromListingToggle,
    openNearestInfoWindow,
    resetAllMarkerIcons,
    showAllMarkers
};