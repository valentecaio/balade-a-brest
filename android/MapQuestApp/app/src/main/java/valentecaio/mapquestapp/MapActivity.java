package valentecaio.mapquestapp;

import android.content.Context;
import android.content.Intent;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;
import android.widget.Button;

import com.mapbox.mapboxsdk.annotations.Marker;
import com.mapbox.mapboxsdk.annotations.MarkerOptions;
import com.mapbox.mapboxsdk.camera.CameraUpdateFactory;
import com.mapbox.mapboxsdk.geometry.LatLng;
import com.mapquest.mapping.MapQuestAccountManager;
import com.mapquest.mapping.maps.MapView;
import com.mapquest.mapping.maps.MapboxMap;
import com.mapquest.mapping.maps.OnMapReadyCallback;

import java.util.ArrayList;
import java.util.Collections;
import java.util.Comparator;
import java.util.List;

public class MapActivity extends AppCompatActivity implements LocationListener, View.OnClickListener {
    private MapboxMap mMapboxMap;
    private MapView mMapView;
    private Button camera;

    private LocationManager locationManager;
    private Marker target_marker;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        MapQuestAccountManager.start(getApplicationContext());

        setContentView(R.layout.activity_map);

        // config camera bucton
        camera = (Button) findViewById(R.id.camera_button);
        camera.setOnClickListener(this);

        // config map
        mMapView = (MapView) findViewById(R.id.mapquestMapView);
        mMapView.onCreate(savedInstanceState);
        configureMap();

        // config GPS
        // Getting LocationManager object
        locationManager = (LocationManager) getSystemService(Context.LOCATION_SERVICE);
        try {
            locationManager.requestLocationUpdates(locationManager.GPS_PROVIDER, 2000, 1, this);
            GlobalVariables.getInstance().userLocation = getLastBestLocation();
        } catch (SecurityException ex){
            ex.printStackTrace();
        }
    }

    private void configureMap(){
        // load map data
        mMapView.getMapAsync(new OnMapReadyCallback() {
            @Override
            public void onMapReady(MapboxMap mapboxMap) {
                mMapboxMap = mapboxMap;

                enableUserTracking(mMapboxMap);

                // put points on the map
                for(Point p: GlobalVariables.getInstance().balade.getPoints()){
                    addMarker(mMapboxMap, p.getLocation(), p.getName(), "");
                }

                Location userLocation = GlobalVariables.getInstance().userLocation;

                // set first user location and first target
                target_marker = sortMarkersbyDistance(mMapboxMap.getMarkers(), userLocation).get(0);

                // center map in user's location
                LatLng center = new LatLng(userLocation);
                mMapboxMap.moveCamera(CameraUpdateFactory.newLatLngZoom(center, 17));

                // set listener to markers
                mMapboxMap.setOnInfoWindowClickListener(new MapboxMap.OnInfoWindowClickListener() {
                    @Override
                    public boolean onInfoWindowClick(@NonNull Marker marker) {
                        // put clicked point in global variables
                        GlobalVariables.getInstance().target = findPointByName(marker.getTitle());
                        Log.i("MAP_ACTIVITY", "new target: " + GlobalVariables.getInstance().target);

                        // start intent
                        Intent i = new Intent(MapActivity.this, InfoActivity.class);
                        startActivity(i);
                        return true;
                    }
                });
            }
        });

    }

    private void enableUserTracking(MapboxMap mMapboxMap) {
        try {
            mMapboxMap.setMyLocationEnabled(true);
        } catch (SecurityException ex){
            ex.printStackTrace();
        }
    }

    private void addMarker(MapboxMap mapboxMap, LatLng position, String title, String snippet) {
        MarkerOptions marker = new MarkerOptions();
        marker.position(position);
        marker.title(title);
        marker.snippet(snippet);
        mapboxMap.addMarker(marker);
    }

    @Override
    public void onClick(View view) {
        Intent i = new Intent(this, CameraActivity.class);

        // get target and stock it in global variables
        GlobalVariables.getInstance().target = findPointByName(target_marker.getTitle());
        Log.i("MAP_ACTIVITY", "new target: " + GlobalVariables.getInstance().target);

        startActivity(i);
    }

    public static List<Marker> sortMarkersbyDistance(List<Marker> markers, final Location location){
        Collections.sort(markers, new Comparator<Marker>() {
            @Override
            public int compare(Marker marker2, Marker marker1) {
                if(getDistanceBetweenPoints(marker1.getPosition(), location) >
                        getDistanceBetweenPoints(marker2.getPosition(),location)){
                    return -1;
                } else {
                    return 1;
                }
            }
        });
        return markers;
    }

    public static float getDistanceBetweenPoints(LatLng firstPos, Location secondPos) {
        float[] results = new float[1];
        Location.distanceBetween(firstPos.getLatitude(), firstPos.getLongitude(), secondPos.getLatitude(), secondPos.getLongitude(), results);
        return results[0];
    }

    @Override
    public void onLocationChanged(Location location) {
        GlobalVariables.getInstance().userLocation = location;
        target_marker = sortMarkersbyDistance(mMapboxMap.getMarkers(), location).get(0);
        Log.i("SORTED", "sorted markers by distance, new target: " + target_marker.getTitle());
    }

    /**
     * @return the last know best location
     */
    private Location getLastBestLocation() throws SecurityException {
        Location locationGPS = locationManager.getLastKnownLocation(LocationManager.GPS_PROVIDER);
        Location locationNet = locationManager.getLastKnownLocation(LocationManager.NETWORK_PROVIDER);

        long GPSLocationTime = 0;
        if (null != locationGPS) {
            GPSLocationTime = locationGPS.getTime();
        }

        long NetLocationTime = 0;

        if (null != locationNet) {
            NetLocationTime = locationNet.getTime();
        }

        if (0 < GPSLocationTime - NetLocationTime) {
            return locationGPS;
        } else {
            return locationNet;
        }
    }

    private Point findPointByName(String name){
        for(Point p: GlobalVariables.getInstance().balade.getPoints()){
            if(p.getName().equals(name)){
                return p;
            }
        }
        return null;
    }

    @Override
    public void onResume()
    { super.onResume(); mMapView.onResume(); }

    @Override
    public void onPause()
    { super.onPause(); mMapView.onPause(); }

    @Override
    protected void onDestroy()
    { super.onDestroy(); mMapView.onDestroy(); }

    @Override
    protected void onSaveInstanceState(Bundle outState)
    { super.onSaveInstanceState(outState); mMapView.onSaveInstanceState(outState); }

    @Override
    public void onStatusChanged(String s, int i, Bundle bundle) {  }

    @Override
    public void onProviderEnabled(String s) { }

    @Override
    public void onProviderDisabled(String s) { }
}
