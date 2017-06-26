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

    private Location myLocation;
    private LocationManager locationManager;
    private MyMarker target_marker;
    private ArrayList<MyMarker> mapMarkers = new ArrayList<>();

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
                    addMarker(p);
                }

                // set first user location and first target
                myLocation = getLastBestLocation();
                target_marker = sortMarkersbyDistance(mapMarkers, myLocation).get(0);

                // center map in user's location
                LatLng center = new LatLng(myLocation);
                mMapboxMap.moveCamera(CameraUpdateFactory.newLatLngZoom(center, 17));

                // set listener to markers
                mMapboxMap.setOnInfoWindowClickListener(new MapboxMap.OnInfoWindowClickListener() {
                    @Override
                    public boolean onInfoWindowClick(@NonNull Marker marker) {
                        // get clicked point
                        int marker_index = mMapboxMap.getMarkers().indexOf(marker);
                        MyMarker clicked_marker = mapMarkers.get(marker_index);
                        Log.i("ONCLICK", "marker index: " + marker_index + ", point: " + clicked_marker.point);

                        // put clicked point in global variables
                        GlobalVariables.getInstance().target = clicked_marker.point;

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

    private void addMarker(Point p) {
        MyMarker marker = new MyMarker(p);
        mMapboxMap.addMarker(marker.markeroptions);
        this.mapMarkers.add(marker);
    }

    private class MyMarker {
        MarkerOptions markeroptions;
        Point point;

        public MyMarker(Point p) {
            markeroptions = new MarkerOptions();
            markeroptions.position(p.getLocation());
            markeroptions.title(p.getName());
            //markeroptions.snippet(p.getDescription());
            this.point = p;
        }
    }

    @Override
    public void onClick(View view) {
        Intent i = new Intent(this, CameraActivity.class);

        // stock target in global variables
        GlobalVariables.getInstance().target = target_marker.point;

        startActivity(i);
    }

    public static List<MyMarker> sortMarkersbyDistance(List<MyMarker> markers, final Location location){
        Collections.sort(markers, new Comparator<MyMarker>() {
            @Override
            public int compare(MyMarker marker2, MyMarker marker1) {
                if(getDistanceBetweenPoints(marker1.markeroptions.getPosition(), location) >
                        getDistanceBetweenPoints(marker2.markeroptions.getPosition(),location)){
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
        myLocation = location;
        target_marker = sortMarkersbyDistance(this.mapMarkers, location).get(0);
        Log.i("SORTED", "sorted markers by distance, new target: " + target_marker);
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
