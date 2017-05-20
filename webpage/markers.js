function addmarkers(){

map4 = new OpenLayers.Map("mapdiv");
map4.addLayer(new OpenLayers.Layer.OSM());

epsg4326 =  new OpenLayers.Projection("EPSG:4326"); //WGS 1984 projection
projectTo = map4.getProjectionObject(); //The map projection (Spherical Mercator)

var lonLat = new OpenLayers.LonLat(-4.50010299 , 48.38423089).transform(epsg4326, projectTo);
var zoom=14;
map4.setCenter (lonLat, zoom);


map = new OpenLayers.Map("mapdiv1");
map.addLayer(new OpenLayers.Layer.OSM());

epsg4326 =  new OpenLayers.Projection("EPSG:4326"); //WGS 1984 projection
projectTo = map.getProjectionObject(); //The map projection (Spherical Mercator)

var lonLat = new OpenLayers.LonLat(-4.50010299 , 48.38423089).transform(epsg4326, projectTo);
var zoom=14;
map.setCenter (lonLat, zoom);

var vectorLayer = new OpenLayers.Layer.Vector("Overlay");

// Define markers as "features" of the vector layer:
var feature = new OpenLayers.Feature.Vector(
        new OpenLayers.Geometry.Point(-4.5110042190 , 48.382436270).transform(epsg4326, projectTo),
        {description:'HUEHUE'} ,
        {externalGraphic: 'image_marker.png', graphicHeight: 30, graphicWidth: 30, graphicXOffset:-12, graphicYOffset:-25  }
    );    
vectorLayer.addFeatures(feature);

var feature = new OpenLayers.Feature.Vector(
        new OpenLayers.Geometry.Point(-4.5210042190 , 48.382435270).transform(epsg4326, projectTo),
        {description:'HU3'} ,
        {externalGraphic: 'image_marker.png', graphicHeight: 30, graphicWidth: 30, graphicXOffset:-12, graphicYOffset:-25  }
    );    
vectorLayer.addFeatures(feature);

var feature = new OpenLayers.Feature.Vector(
        new OpenLayers.Geometry.Point(-4.5010042190 , 48.392435270).transform(epsg4326, projectTo),
        {description:'Vamo Porra'} ,
        {externalGraphic: 'image_marker.png', graphicHeight: 30, graphicWidth: 30, graphicXOffset:-12, graphicYOffset:-25  }
    );    
vectorLayer.addFeatures(feature);

var feature = new OpenLayers.Feature.Vector(
        new OpenLayers.Geometry.Point(-4.5116042190 , 48.392936270).transform(epsg4326, projectTo),
        {description:'HUEHUE'} ,
        {externalGraphic: 'image_marker.png', graphicHeight: 30, graphicWidth: 30, graphicXOffset:-12, graphicYOffset:-25  }
    );    
vectorLayer.addFeatures(feature);

map.addLayer(vectorLayer);


//Add a selector control to the vectorLayer with popup functions
var controls = {
  selector: new OpenLayers.Control.SelectFeature(vectorLayer, { onSelect: createPopup, onUnselect: destroyPopup })
};

function createPopup(feature) {
  feature.popup = new OpenLayers.Popup.FramedCloud("pop",
      feature.geometry.getBounds().getCenterLonLat(),
      null,
      '<div class="markerContent">'+feature.attributes.description+'</div>',
      null,
      true,
      function() { controls['selector'].unselectAll(); }
  );
  //feature.popup.closeOnMove = true;
  map.addPopup(feature.popup);
}
function destroyPopup(feature) {
  feature.popup.destroy();
  feature.popup = null;
}
map.addControl(controls['selector']);
controls['selector'].activate();



map2 = new OpenLayers.Map("mapdiv2");
map2.addLayer(new OpenLayers.Layer.OSM());
//epsg4326 =  new OpenLayers.Projection("EPSG:4326"); //WGS 1984 projection
projectTo = map2.getProjectionObject(); //The map projection (Spherical Mercator)

//var lonLat = new OpenLayers.LonLat(-4.50010299 , 48.38423089).transform(epsg4326, projectTo);
      

//var zoom=14;
map2.setCenter (lonLat, zoom);

var vectorLayer2 = new OpenLayers.Layer.Vector("Overlay");

// Define markers as "features" of the vector layer:
var feature2 = new OpenLayers.Feature.Vector(
        new OpenLayers.Geometry.Point(-4.5240042190 , 48.382436270).transform(epsg4326, projectTo),
        {description:'HUEHUEad'} ,
        {externalGraphic: 'image_marker.png', graphicHeight: 30, graphicWidth: 30, graphicXOffset:-12, graphicYOffset:-25  }
    );    
vectorLayer2.addFeatures(feature2);

var feature2 = new OpenLayers.Feature.Vector(
        new OpenLayers.Geometry.Point(-4.5210042190 , 48.382435270).transform(epsg4326, projectTo),
        {description:'HU313'} ,
        {externalGraphic: 'image_marker.png', graphicHeight: 30, graphicWidth: 30, graphicXOffset:-12, graphicYOffset:-25  }
    );    
vectorLayer2.addFeatures(feature2);

var feature2 = new OpenLayers.Feature.Vector(
        new OpenLayers.Geometry.Point(-4.5010042190 , 48.392435270).transform(epsg4326, projectTo),
        {description:'Vamo Porra11'} ,
        {externalGraphic: 'image_marker.png', graphicHeight: 30, graphicWidth: 30, graphicXOffset:-12, graphicYOffset:-25  }
    );    
vectorLayer2.addFeatures(feature2);

var feature2 = new OpenLayers.Feature.Vector(
        new OpenLayers.Geometry.Point(-4.5116042190 , 48.392936270).transform(epsg4326, projectTo),
        {description:'HUEHUE12'} ,
        {externalGraphic: 'image_marker.png', graphicHeight: 30, graphicWidth: 30, graphicXOffset:-12, graphicYOffset:-25  }
    );    
vectorLayer2.addFeatures(feature2);

map2.addLayer(vectorLayer2);


map3 = new OpenLayers.Map("mapdiv3");
map3.addLayer(new OpenLayers.Layer.OSM());
projectTo = map3.getProjectionObject(); //The map projection (Spherical Mercator)
map3.setCenter (lonLat, zoom);

var vectorLayer3 = new OpenLayers.Layer.Vector("Overlay");

// Define markers as "features" of the vector layer:
var feature3 = new OpenLayers.Feature.Vector(
        new OpenLayers.Geometry.Point(-4.5250042190 , 48.382436270).transform(epsg4326, projectTo),
        {description:'HUEHUEad'} ,
        {externalGraphic: 'image_marker.png', graphicHeight: 30, graphicWidth: 30, graphicXOffset:-12, graphicYOffset:-25  }
    );    
vectorLayer3.addFeatures(feature3);

var feature3 = new OpenLayers.Feature.Vector(
        new OpenLayers.Geometry.Point(-4.5210042190 , 48.386435270).transform(epsg4326, projectTo),
        {description:'HU313'} ,
        {externalGraphic: 'image_marker.png', graphicHeight: 30, graphicWidth: 30, graphicXOffset:-12, graphicYOffset:-25  }
    );    
vectorLayer3.addFeatures(feature3);

var feature3 = new OpenLayers.Feature.Vector(
        new OpenLayers.Geometry.Point(-4.5015042190 , 48.394435270).transform(epsg4326, projectTo),
        {description:'Vamo Porra11'} ,
        {externalGraphic: 'image_marker.png', graphicHeight: 30, graphicWidth: 30, graphicXOffset:-12, graphicYOffset:-25  }
    );    
vectorLayer3.addFeatures(feature3);

var feature3 = new OpenLayers.Feature.Vector(
        new OpenLayers.Geometry.Point(-4.5116742190 , 48.39236270).transform(epsg4326, projectTo),
        {description:'HUEHUE12'} ,
        {externalGraphic: 'image_marker.png', graphicHeight: 30, graphicWidth: 30, graphicXOffset:-12, graphicYOffset:-25  }
    );    
vectorLayer3.addFeatures(feature3);

map3.addLayer(vectorLayer3);

}


