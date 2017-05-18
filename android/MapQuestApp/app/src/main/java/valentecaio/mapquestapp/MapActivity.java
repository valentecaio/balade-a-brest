package valentecaio.mapquestapp;

import android.content.Intent;
import android.location.Location;
import android.location.LocationListener;
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
import java.util.Arrays;
import java.util.Collections;
import java.util.Comparator;
import java.util.List;

public class MapActivity extends AppCompatActivity implements LocationListener, View.OnClickListener {
    private MapboxMap mMapboxMap;
    private MapView mMapView;
    private Button camera;

    private Location myLocation;
    private Marker nearest_marker;

    ArrayList<Point> points = new ArrayList<Point>();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        MapQuestAccountManager.start(getApplicationContext());

        setContentView(R.layout.activity_map);

        camera = (Button) findViewById(R.id.camera_button);
        camera.setOnClickListener(this);

        mMapView = (MapView) findViewById(R.id.mapquestMapView);
        mMapView.onCreate(savedInstanceState);
        configureMap();
    }

    private void configureMap(){
        // load map data
        mMapView.getMapAsync(new OnMapReadyCallback() {
            @Override
            public void onMapReady(MapboxMap mapboxMap) {
                mMapboxMap = mapboxMap;

                enableUserTracking(mMapboxMap);

                // create points
                Point tour = new Point("tour", 48.383421, -4.497139);
                Point jardin = new Point("jardin", 48.381615, -4.499135);
                Point tram = new Point("tram", 48.384105, -4.499425);
                Point laverie = new Point("laverie", 48.357061, -4.570031);
                Point cv = new Point("centre vie", 48.358906, -4.570013);
                Point c5 = new Point("departement des langues", 48.359004, -4.569447);
                Point imt_statue = new Point("imt statue", 48.360124, -4.570747);

                // put points in array
                Point[] array = new Point[] { tour, jardin, tram, laverie, cv, c5, imt_statue };
                points = new ArrayList<Point>(Arrays.asList(array));

                // put points on the map
                for(Point p: points){
                    addMarker(mMapboxMap, p.getLocation(), p.getName(), "");
                }
                // initialize nearest_marker
                nearest_marker = mMapboxMap.getMarkers().get(0);

                // center map
                mMapboxMap.moveCamera(CameraUpdateFactory.newLatLngZoom(cv.getLocation(), 17));

                // set listener to markers
                mMapboxMap.setOnInfoWindowClickListener(new MapboxMap.OnInfoWindowClickListener() {
                    @Override
                    public boolean onInfoWindowClick(@NonNull Marker marker) {
                        Log.i("info", marker.getTitle());
                        Intent i = new Intent(MapActivity.this, InfoActivity.class);
                        i.putExtra("id", marker.getTitle());
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
        MarkerOptions markerOptions = new MarkerOptions();
        markerOptions.position(position);
        markerOptions.title(title);
        markerOptions.snippet(snippet);
        mapboxMap.addMarker(markerOptions);
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
    public void onClick(View view) {
        Log.i("clicks","You Clicked B1");
        Intent i = new Intent(this, CameraActivity.class);

        String marker_name = nearest_marker.getTitle();
        Point point = points.get(points.indexOf(new Point(marker_name, 0 ,0)));

        i.putExtra("target_name", point.getName());
        i.putExtra("target_longitude", point.getLongitude());
        i.putExtra("target_latitude", point.getLatitude());

        startActivity(i);
    }

    public static List<Marker> sortMarkersbyDistance(List<Marker> markers, final Location location){
        Collections.sort(markers, new Comparator<Marker>() {
            @Override
            public int compare(Marker marker2, Marker marker1) {
                if(getDistanceBetweenPoints(marker1.getPosition(), location)>getDistanceBetweenPoints(marker2.getPosition(),location)){
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
        nearest_marker = sortMarkersbyDistance(mMapboxMap.getMarkers(), location).get(0);
    }

    @Override
    public void onStatusChanged(String s, int i, Bundle bundle) {  }

    @Override
    public void onProviderEnabled(String s) { }

    @Override
    public void onProviderDisabled(String s) { }
}
