package valentecaio.mapquestapp;

import android.content.Intent;
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

public class MapActivity extends AppCompatActivity implements View.OnClickListener {
    private MapboxMap mMapboxMap;
    private MapView mMapView;
    private Button camera;

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
                LatLng tour = new LatLng(48.383421, -4.497139);
                LatLng jardin = new LatLng(48.381615, -4.499135);
                LatLng tram = new LatLng(48.384105, -4.499425);

                LatLng quarto_yan = new LatLng(48.356609, -4.570390);
                LatLng laverie = new LatLng(48.357061, -4.570031);
                LatLng d1_128b = new LatLng(48.359158, -4.570728);

                LatLng cv = new LatLng(48.358906, -4.570013);
                LatLng c5 = new LatLng(48.359004, -4.569447);
                LatLng imt_statue = new LatLng(48.360124, -4.570747);


                // center map
                mMapboxMap.moveCamera(CameraUpdateFactory.newLatLngZoom(d1_128b, 17));

                // put points in map
                addMarker(mMapboxMap, tour, "tour", "");
                addMarker(mMapboxMap, jardin, "jardin", "");
                addMarker(mMapboxMap, tram, "tram", "");
                addMarker(mMapboxMap, quarto_yan, "chambre yan", "");
                addMarker(mMapboxMap, laverie, "laverie", "");
                addMarker(mMapboxMap, d1_128b, "d1_128b", "");
                addMarker(mMapboxMap, cv, "centre vie", "");
                addMarker(mMapboxMap, c5, "departement des langues", "");
                addMarker(mMapboxMap, imt_statue, "imt statue", "");

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
        startActivity(i);
    }
}
