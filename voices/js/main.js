function generateMap() {
    map = createMap('map', latitude, longitude, defaultZoom);
    map.addControl(new OpenLayers.Control.Navigation());
}