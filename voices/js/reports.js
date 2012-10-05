function loadSelectedView() {
    map = createMap('map', latitude, longitude, defaultZoom);
    for (var i = 0; i < map.controls.length; i++) {
        map.removeControl(map.controls[i]);
        map.controls[i].destroy();
    }
    if (window.location.hash == "#map") {
        loadMap();
    }
    else if (window.location.hash == "#list") {
        loadList();
    }
    else if (window.location.hash == "#gallery") {
        loadGallery();
    }
    else {
        loadList();
    }
}
function loadMap() {
    $("#header-map").addClass("selected");
    $("#header-list").removeClass("selected");
    $("#header-gallery").removeClass("selected");
    $("#list").hide();
    $("#gallery").hide();
    populateMap();
}
function loadList() {
    $("#header-map").removeClass("selected");
    $("#header-list").addClass("selected");
    $("#header-gallery").removeClass("selected");
    $("#gallery").hide();
    $("#list").show();
    splitListView();
    clearMap();
}
function loadGallery() {
    $("#header-map").removeClass("selected");
    $("#header-list").removeClass("selected");
    $("#header-gallery").addClass("selected");
    $("#list").hide();
    $("#gallery").show();
    clearMap();
}
function splitListView() {
    if ($('#list').css("display") != "none") {
        var width = $(window).width();
        if (width > 2000) {
            addColumns("#list", ".report-item", 6);
        }
        else if (width > 1600) {
            addColumns("#list", ".report-item", 5);
        }
        else if (width > 1280) {
            addColumns("#list", ".report-item", 4);
        }
        else if (width > 820) {
            addColumns("#list", ".report-item", 3);
        }
        else if (width > 640) {
            addColumns("#list", ".report-item", 2);
        }
        else {
            addColumns("#list", ".report-item", 1);
        }
    }
}
function addReportViewEvents() {
    $("#header-map a").click(function(){
        loadMap();
    });
    $("#header-list a").click(function(){
        loadList();
    });
    $("#header-gallery a").click(function(){
        loadGallery();
    });
}
function addColumns(target, item, count) {
    var $target = $(target);
    if ($(".column").size() != count) {
        $target.hide();
        $('.column > ' + item).unwrap();
        $('.column').remove();
        var width = (100 - (count*2)) / count;
        for (var i = 1 ; i < count + 1 ; i++){
            var $column = $("<div id='column-" + i + "' class='column' style='width:" + width + "%'>");
            $column.appendTo($target);
        }
        var index = 1;
        var $items = $(item);
        $items.sort(function(a, b) {
            var ordinalA = parseInt($(a).attr('title'));
            var ordinalB = parseInt($(b).attr('title'));
            return (ordinalA < ordinalB) ? -1 : (ordinalA > ordinalB) ? 1 : 0;
        });
        $.each($items, function() {
            $(this).appendTo($("#column-" + index));
            if (index < count) {
                index = index + 1;
            }
            else {
                index = 1;
            }
        });
    }
    $target.show();
}
function generateMap() {
    map = createMap('map', latitude, longitude, defaultZoom);
    for (var i = 0; i < map.controls.length; i++) {
        map.removeControl(map.controls[i]);
        map.controls[i].destroy();
    }
}
function clearMap() {
    if (map != null && 'getLayersByName' in map) {
        if (popup != null && 'destroy' in popup) {
            map.removePopup(popup);
            popup.destroy();
        }
        var reportLayers = map.getLayersByName($PHRASES.reports);
        for (var i = 0; i < reportLayers.length; i++) {
            map.removeLayer(reportLayers[i]);
            reportLayers[i].destroy();
        }
        var checkinLayers = map.getLayersByName($PHRASES.checkins);
        for (var j = 0; j < checkinLayers.length; j++){
            map.removeLayer(checkinLayers[j]);
            checkinLayers[j].destroy();
        }
    }
}
function populateMap() {
    setTimeout(function(){
        populateMapWithLayers();
        populateMapWithReports();
        populateMapWithCheckins();
        populateMapWithControls();
    }, 400);
}
function populateMapWithLayers() {
    $.each($LAYERS, function(i, layer) {
        var kmlLayers = map.getLayersByName(layer.name);
        for (var j = 0; j < kmlLayers.length; j++) {
            map.removeLayer(kmlLayers[j]);
        }
        var kmlLayer = new OpenLayers.Layer.Vector(layer.name, {
            projection: map.displayProjection,
            strategies: [new OpenLayers.Strategy.Fixed()],
            protocol: new OpenLayers.Protocol.HTTP({
                url: layer.url,
                format: new OpenLayers.Format.KML({
                    extractStyles: true,
                    extractAttributes: true})
            })
        });
        map.addLayer(kmlLayer);
        addFeatureSelectionEvents(map, kmlLayer);
    });
}
function populateMapWithReports() {
    var reportLayers = map.getLayersByName($PHRASES.reports);
    for (var i = 0; i < reportLayers.length; i++) {
        map.removeLayer(reportLayers[i]);
    }
    var reportLayer = new OpenLayers.Layer.Vector($PHRASES.reports, {
        projection: map.displayProjection,
        extractAttributes: true,
        styleMap: new OpenLayers.StyleMap({
            'default' : new OpenLayers.Style({
                cursor: "pointer",
                graphicOpacity: 0.9,
                graphicWidth: 40,
                graphicHeight: 40,
                externalGraphic: "${externalGraphic}"
            })})
    });
    map.addLayer(reportLayer);
    addFeatureSelectionEvents(map, reportLayer);
    $.each($INCIDENTS, function(i, incident) {
        var point = new OpenLayers.Geometry.Point(parseFloat(incident.longitude), parseFloat(incident.latitude));
        point.transform(proj_4326, proj_900913);
        var externalGraphic = $PHRASES.server + "/themes/voices/images/report_red.png";
        if (incident.icon) {
            externalGraphic = incident.icon;
        }
        //debugger;
        var vector = new OpenLayers.Feature.Vector(point, {
            id:incident.id,
            link:incident.link,
            time:incident.time,
            date:incident.date,
            title:incident.title,
            ratings:incident.ratings,
            rating:incident.rating,
            comments:incident.comments,
            description:incident.description,
            location:incident.location,
            latitude:incident.latitude,
            longitude:incident.longitude,
            categories:incident.categories,
            photos:incident.photos,
            externalGraphic:externalGraphic
        });
        reportLayer.addFeatures([vector]);
    });
}
function populateMapWithCheckins() {
    var checkinStyles = new OpenLayers.StyleMap({
        "default": new OpenLayers.Style({
            cursor: "pointer",
            graphicOpacity: 0.9,
            graphicWidth: 40,
            graphicHeight: 40,
            externalGraphic: $PHRASES.server + "/themes/facilities/images/checkin_red.png"
        })
    });
    var checkinLayers = map.getLayersByName($PHRASES.checkins);
    for (var i = 0; i < checkinLayers.length; i++){
        map.removeLayer(checkinLayers[i]);
    }
    var checkinLayer = new OpenLayers.Layer.Vector($PHRASES.checkins, {styleMap: checkinStyles});
    map.addLayers([checkinLayer]);
    $.getJSON($PHRASES.server + "/api/?task=checkin&action=get_ci&mapdata=1&sqllimit=1000&orderby=checkin.checkin_date&sort=ASC", function(data) {
        if (data && data["payload"] && data["payload"]["checkins"]) {
            $.each(data["payload"]["checkins"], function(key, checkin) {
                var checkinPoint = new OpenLayers.Geometry.Point(parseFloat(checkin.lon), parseFloat(checkin.lat));
                checkinPoint.transform(proj_4326, proj_900913);
                var media_link = '';
                var media_medium = '';
                var media_thumb = '';
                if (checkin.media !== undefined) {
                    media_link = checkin.media[0].link;
                    media_medium = checkin.media[0].medium;
                    media_thumb = checkin.media[0].thumb;
                }
                var checkinVector = new OpenLayers.Feature.Vector(checkinPoint, {
                    ci_id: checkin.id,
                    ci_msg: checkin.msg,
                    ci_media_link: media_link,
                    ci_media_medium: media_medium,
                    ci_media_thumb: media_thumb
                });
                checkinLayer.addFeatures([checkinVector]);
            });
        }
    });
}
function populateMapWithControls() {
    var selectControls = [];
    $.each(map.layers, function(i, layer) {
        if (layer.name  === $PHRASES.reports) {
            selectControls.push(layer);
            layer.events.on({
                "featureselected": showReportData,
                "featureunselected": onFeatureUnselect
            });
        }
        else if (layer.name === $PHRASES.checkins) {
            selectControls.push(layer);
            layer.events.on({
                "featureselected": showCheckinData,
                "featureunselected": onFeatureUnselect
            });
        }
        else  {
            $.each($LAYERS, function(i, item) {
                if (layer.name === item.name) {
                    selectControls.push(layer);
                    layer.events.on({
                        "featureselected": showKmlData,
                        "featureunselected": onFeatureUnselect
                    });
                }
            });
        }
    });
    var selectFeatures = new OpenLayers.Control.SelectFeature(selectControls);
    map.addControl(selectFeatures);
    selectFeatures.activate();
}
function showKmlData(event) {
    selectedFeature = event.feature;
    zoom_point = event.feature.geometry.getBounds().getCenterLonLat();
    lon = zoom_point.lon;
    lat = zoom_point.lat;
    if (event.feature.popup != null) {
        map.removePopup(event.feature.popup);
    }
    var content = "<div id=\"popup\">";
    var name = event.feature.attributes.name;
    if (name != null) {
        content += "<div id=\"popup-title\">";
        content += name;
        content += "</div>";
    }
    var description = event.feature.attributes.description;
    if (description != null) {
        content += "<div id=\"popup-description\">";
        content += description;
        content += "</div>";
    }
    content += "<div style=\"clear:both;\"></div></div>";
    var popup = new OpenLayers.Popup.FramedCloud("popup",
        event.feature.geometry.getBounds().getCenterLonLat(),
        new OpenLayers.Size(200,300),
        content,
        null, true, onPopupClose);
    event.feature.popup = popup;
    map.addPopup(popup);
}
function showReportData(event) {
    selectedFeature = event.feature;
    zoom_point = event.feature.geometry.getBounds().getCenterLonLat();
    lon = zoom_point.lon;
    lat = zoom_point.lat;
    if (event.feature.popup != null) {
        map.removePopup(event.feature.popup);
    }
    var content = "<div id=\"popup\">";
    var incident = event.feature.attributes;
    content += "<ul class='vertical vote'>";
    content += "<li class='vote-up'><a title='Vote Up' href=\"javascript:vote('" + incident.id + "','add','original','popup-vote-" + incident.id + "')\"></a></li>";
    content += "<li class='vote-value' id='popup-vote-" + incident.id + "'>"  + incident.rating + "</li>";
    content += "<li class='vote-down'><a title='Vote Down' href=\"javascript:vote('" + incident.id + "','subtract','original','popup-vote-" + incident.id + "')\"></a></li>";
    content += "</ul>";

    if (incident.photos && incident.photos.length > 0) {
        var photo = incident.photos[0];
        if (typeof photo !== "undefined" && typeof photo.thumb !== "undefined") {
            content += "<div class=\"popup-image\">";
            content += "<a title=\"" + incident.title + "\" href=\"" + $PHRASES.server + "reports/view/" + incident.id + "\">";
            content += "<img src=\"" + $PHRASES.server + "/media/uploads/" + photo.thumb + "\" height=\"59\" width=\"89\" />";
            content += "</a></div>";
        }
    }
    content += "<div class='popup-primary'>";
    content += "<a title=\"" + incident.title + "\" href=\"" + $PHRASES.server + "reports/view/" + incident.id + "\">";
    $.each(incident.categories, function(i, category) {
        content += "<span class='popup-question'>" + category.title + "</span>";
    });
    if (incident.title && incident.title!='') {
        content += "<span class='popup-answer'>" + incident.title + "</span>";
    }
    content += "</a></div>";
    content += "<div class='popup-about'>";
    if (incident.location && incident.location != '') {
        content += "<span class='popup-location'>" + incident.location + "</span>";
    }
    if (incident.date && incident.date != '') {
        content += " on <span class='popup-date'>" + incident.date + "</span>";
    }
    content += "</div>";
    content += "<div style=\"clear:both;\"></div></div>";
    popup = new OpenLayers.Popup.FramedCloud("popup",
        event.feature.geometry.getBounds().getCenterLonLat(),
        new OpenLayers.Size(200,300),
        content,
        null, true, onPopupClose);
    event.feature.popup = popup;
    map.addPopup(popup);
}
function showCheckinData(event) {
    selectedFeature = event.feature;
    zoom_point = event.feature.geometry.getBounds().getCenterLonLat();
    lon = zoom_point.lon;
    lat = zoom_point.lat;

    var content = "<div class=\"infowindow\" style=\"color:#000000\"><div class=\"infowindow_list\">";
    if(event.feature.attributes.ci_media_medium !== "") {
        content += "<a href=\""+event.feature.attributes.ci_media_link+"\" rel=\"lightbox-group1\" title=\""+event.feature.attributes.ci_msg+"\">";
        content += "<img src=\""+event.feature.attributes.ci_media_medium+"\" /><br/>";
    }

    content += event.feature.attributes.ci_msg+"</div><div style=\"clear:both;\"></div>";
    content += "<div class=\"infowindow_meta\">";
    content += "</div>";

    popup = new OpenLayers.Popup.FramedCloud("checkin",
        event.feature.geometry.getBounds().getCenterLonLat(),
        new OpenLayers.Size(100,100),
        content,
        null, true, onPopupClose);
    event.feature.popup = popup;
    map.addPopup(popup);
}
function getParameter(name) {
   return decodeURI((RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]);
}
function vote(id,action,type,value) {
    var previous =  $("#" + value).html();
    $("#" + value).html('<img src="' + $PHRASES.server + '/themes/voices/images/loading.gif">');
    $.post($PHRASES.server + 'reports/rating/' + id, {action: action, type: type},
        function(data){
            if (data.status == 'saved') {
                $("#" + value).html("" + data.rating);
            }
            else {
                $("#" + value).html(previous);
                if(typeof(data.message) != 'undefined') {
                    alert(data.message);
                }
            }
    }, "json");
}