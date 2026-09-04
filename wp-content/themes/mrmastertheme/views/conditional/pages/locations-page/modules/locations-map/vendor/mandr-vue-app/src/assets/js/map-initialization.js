import { reactive } from 'vue';
import { map_manipulation } from './map-manipulation';

const state = reactive({
    google: window.google,
    map_bounds: '',
    map_options: {},
}); 

const initializeMap = (locations) => { 
    //initialize the map bounds:
    state.map_bounds = new google.maps.LatLngBounds();

    //initialize the map options:
    state.map_options = {
        center: state.map_bounds.getCenter(),
        draggable: true,
        scrollwheel: false,
        zoom: 10,
        minZoom: 4,
        maxZoom: 16,
        streetViewControl: false,
        panControl: true,
        zoomControl: true,
        gestureHandling: 'cooperative',
        //In order to use Advanced Markers, a map ID from Google Dev Console is necessary:
        mapId: '3b1021aabdb80672',
    };

    //declare the map and initiate it with the options set above:
    const map = new map_initialization.state.google.maps.Map(
        document.getElementById('map'),
        state.map_options
    );

    //push the map to the state object for later reference & manipulation:
    map_manipulation.state.active_map = map;

    //initialize the markers & infoWindows:
    initializeMarkersAndInfoWindows(locations, map);
  
    //adjust our view of the map so we're only seeing the area that has pins in it
    map.fitBounds(map_initialization.state.map_bounds);

    //I'm not sure what this does tbh but it's in all our other map code
    state.google.maps.visualRefresh = true; 
}; 

const initializeInfoWindowContent = (location) => {
    //declare empty stringvariables that will only get used if the corresponding object properties exist:
    var location_name = '';
    var location_place_id = '';
    var location_address = '';
    var location_phone = '';
    var location_email = '';
    var location_hours = '';
    var location_website = '';
    var location_wp_link = '';

    //if any of the following data exist per location, we'll list them out:
    var open_list_tag = '<ul>';    

    //print location name
    if (location.name) {
        location_name = '<li class="location-name"><h2 class="h3">'+location.name+'</h2></li>';
    } 

    //print location place_id, but keep it visually hidden:
    if (location.place_id) {
        location_place_id = '<li class="location-place-id visually-hidden">'+location.place_id+'</li>';
    } 
    
    //print location address link
    if (location.address && location.place_id) {
        location_address = '<li class="location-address"><strong>Address: </strong><a href="https://www.google.com/maps/place/?q=place_id:'+location.place_id+'" target="_blank">'+location.address+'</a></li>';
    }

    //print location phone number
    if (location.phone) {
        location_phone = '<li class="location-phone"><strong>Phone: </strong><a href="tel:'+location.phone+'">'+location.phone+'</a></li>';
    }

    //print location email address
    if (location.email) {
        location_email = '<li class="location-email"><strong>Email: </strong><a href="mailto:'+location.email+'">'+location.email+'</a></li>';
    }

    //print location hours
    if (location.hours) {
        location_hours = '<li class="location-hours"><strong>Hours: </strong>'+location.hours+'</li>';
    }    

    //print location website link
    if (location.website) {
        location_website = '<li class="location-website"><a class="button" href="'+location.website+'" target="_blank">View Website</a></li>';
    } 

    //print location permalink
    if (location.wp_link) {
        location_wp_link = '<li class="location-wp-link"><a class="button" href="'+location.wp_link+'">View Location</a></li>';
    }

    var close_list_tag = '</ul>'

    //concatenate all of our strings and return it
    var content = open_list_tag + location_name + location_place_id + location_address + location_phone + location_email + location_hours + location_website + location_wp_link + close_list_tag;

    return content;
};

const initializeMarkersAndInfoWindows = (locations , map) => {
    //loop through the locations:
    for (let i = 0; i < locations.length; i++) {
        //Extend the bounds with each location so they all fit in the initial view 
        state.map_bounds.extend({
            lat: parseFloat(locations[i].latitude),
            lng: parseFloat(locations[i].longitude),
        });

        //In order to set up a custom marker icon, you're basically prompting the JavaScript to create an HTML element, then associate it with the marker & override the default image
        var advancedMarkerContent = document.createElement('img');
        advancedMarkerContent.classList.add('advanced-pin');
        advancedMarkerContent.setAttribute(
            'src',
            locations[i].icon_default
        );
        advancedMarkerContent.setAttribute('alt', locations[i].name);
        advancedMarkerContent.setAttribute('width', 44);
        advancedMarkerContent.setAttribute('height', 44);
        //associate the default & active icon URLs & sizing with the marker object so that we can toggle between them later:
        advancedMarkerContent.setAttribute('data-icon-default-url', locations[i].icon_default);
        advancedMarkerContent.setAttribute('data-icon-default-width', 44);
        advancedMarkerContent.setAttribute('data-icon-default-height', 44);

        advancedMarkerContent.setAttribute('data-icon-active-url', locations[i].icon_active);
        advancedMarkerContent.setAttribute('data-icon-active-width', 56);
        advancedMarkerContent.setAttribute('data-icon-active-height', 56);
        

        //initialize the (advanced) marker(s):
        var advanced_marker = new google.maps.marker.AdvancedMarkerElement({
            map,
            position: {
                lat: parseFloat(locations[i].latitude),
                lng: parseFloat(locations[i].longitude),
            },
            title: locations[i].name,
            content: advancedMarkerContent,
        });        

        //we add a custom 'place_id' attribute to the object to more easily establish an association between markers & listings. Luckily, InfoWindows include the place_id in their 'content' attribute via our <a> tag setup. This is all used during searching & sorting:
        advanced_marker.place_id = locations[i].place_id;
                
        //push the marker to the state object for later reference & manipulation:
        map_manipulation.state.all_markers.push(advanced_marker); 

        //initialize & assign the infoWindow(s):
        var info_window = new google.maps.InfoWindow({
            content: initializeInfoWindowContent(locations[i]),
            ariaLabel: locations[i].name,
        });        

        //push the infoWindow to the state object for later reference & manipulation:
        map_manipulation.state.all_info_windows.push(info_window);

        //add click event to the marker, to open infoWindow & do other actions:
        map_manipulation.markerClickEvent(advanced_marker, info_window, locations[i], map);
    }
}

export const map_initialization = {
    state,
    initializeMap, 
};