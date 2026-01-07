(async function () {
    if (document.querySelector('.locations-search-form')) {
        initializeModuleGoogleAutocomplete();
    }
})(); 

async function initializeModuleGoogleAutocomplete() {
    try {
        await google.maps.importLibrary('places');

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
    } catch (error) {
        console.log(error);
    }
}