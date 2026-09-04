import { reactive } from "vue";
import { search_listings } from "./search-listings";
import { map_manipulation } from "./map-manipulation";

const state = reactive({
  google: window.google, 
  user_geolocation: '',
  user_location_string: '',  
});
 
const getUserGeoLocation = async () => {
    //by default keep the user's position set to false
    let user_geolocation = false;

    try {
        //if we're able to retrieve the user's geolocation from the browser within 5 seconds, assign that geolocation to the variable 
        user_geolocation = await new Promise((resolve, reject) => { 
            navigator.geolocation.getCurrentPosition(resolve, reject, {timeout: 5000,});
        });

        //then, push it to the state object for future reference
        state.user_geolocation = user_geolocation;

        //use the geolocation object to format a readable location, used for UX:
        getUserLocationString(state.user_geolocation);
    } catch {
        //if browser permission is denied, or some other error:
        alert('The "Find Nearest" feature requires granting us access to your location.');

        //hide all markers:
        map_manipulation.hideAllMarkers();

        //print a 'no results' message in the listings area:
        search_listings.state.is_search_results_empty = true;
    }

    //return that geolocation or false if failure
    return user_geolocation; 
};

const getUserLocationString = (geolocation_object) => {
    //until the user grants their location access, the state object this function returns is an empty string by default

    //once we've got our user's location, we'll use the Google API to associate a City, State, & Zip with the latitude & longitude
    if (geolocation_object) {
        const geocoder = new state.google.maps.Geocoder();
        const latLng = new state.google.maps.LatLng(
            parseFloat(geolocation_object.coords.latitude),
            parseFloat(geolocation_object.coords.longitude)
        );

        geocoder.geocode({ latLng: latLng }, (results, status) => {
            if (status === state.google.maps.GeocoderStatus.OK) {
                const geoCity = results[0].address_components[2].short_name;
                const geoState = results[0].address_components[4].short_name;
                const geoZip = results[0].address_components[6].short_name;

                //put together a string representation of th user's location:
                const displayAddress = `${geoCity}, ${geoState} ${geoZip}`;

                //apply it to the state object as an html element: 
                state.user_location_string = displayAddress;
            } else {
                alert(`Error finding location: ${status}`);
            }
        });
    }

    return state.user_location_string;
}; 

/**
 * Calculates the haversine distance between point A, and B.
 * @param {number[]} latlngA [lat, lng] point A
 * @param {number[]} latlngB [lat, lng] point B
 * @param {boolean} isMiles If we are using miles, else km.
 *
 * https://stackoverflow.com/questions/14560999/using-the-haversine-formula-in-javascript
 */
const haversineDistance = ([lat1, lon1], [lat2, lon2], isMiles = true) => {
    const toRadian = (angle) => (Math.PI / 180) * angle;
    const distance = (a, b) => (Math.PI / 180) * (a - b);
    const RADIUS_OF_EARTH_IN_KM = 6371;

    const dLat = distance(lat2, lat1);
    const dLon = distance(lon2, lon1);

    lat1 = toRadian(lat1);
    lat2 = toRadian(lat2);

    // Haversine Formula
    const a =
        Math.pow(Math.sin(dLat / 2), 2) +
        Math.pow(Math.sin(dLon / 2), 2) * Math.cos(lat1) * Math.cos(lat2);
    const c = 2 * Math.asin(Math.sqrt(a));

    let finalDistance = RADIUS_OF_EARTH_IN_KM * c;

    if (isMiles) {
        finalDistance /= 1.60934;
    }

    return finalDistance;
};

export const geolocation = {
  state,
  getUserGeoLocation, 
  getUserLocationString,
  haversineDistance
};
