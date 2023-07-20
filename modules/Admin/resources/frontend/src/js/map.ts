import { Loader } from "@googlemaps/js-api-loader";
import { Alpine } from "alpinejs";

declare global {
    interface Window {
        Alpine: Alpine;
    }
}

function positon_value(value: number | (() => number) | undefined): number | null {
    if (typeof value === 'undefined') {
        return null;
    }
    if (typeof value === 'function') {
        return value();
    }
    return value;
}

async function api() {
    const loader = new Loader({
        apiKey: "AIzaSyAmQXS2j9Jnw7pWaxZVq-kvfO7mT_6_MeU",
        version: "weekly",
    });
    const { Map } = await loader.importLibrary("maps");
    const { AdvancedMarkerElement } = await loader.importLibrary("marker");
    return { Map, AdvancedMarkerElement };
}

function map(state: any) {
    const position = { lat: 5.360066650058106, lng: -4.010567707056308 };
    const elements = {
        map: document.querySelector("#map") as HTMLDivElement,
        search: document.getElementById("#search") as HTMLInputElement,
    };

    return {
        state: state,

        async init() {

            if(state.initialValue){
                position.lat = state.initialValue.latitude
                position.lng = state.initialValue.longitude
            }

            const { Map, AdvancedMarkerElement } = await api();
            const map = new Map(elements.map, { center: position, zoom: 12, mapId: '4504f8b37365c3d0' });
            const marker = new AdvancedMarkerElement({ map, position, gmpDraggable: true });

            marker.addListener('dragend', () => {
                this.state = {
                    latitude: positon_value(marker?.position?.lat),
                    longitude: positon_value(marker?.position?.lng)
                };
            });
        }
    }
}

document.addEventListener('alpine:init', async () => {
    window.Alpine.data('map', map);
});