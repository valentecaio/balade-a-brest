package valentecaio.mapquestapp;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;

import com.mapbox.mapboxsdk.annotations.MarkerOptions;
import com.mapbox.mapboxsdk.camera.CameraUpdateFactory;
import com.mapbox.mapboxsdk.geometry.LatLng;
import com.mapquest.mapping.MapQuestAccountManager;
import com.mapquest.mapping.maps.OnMapReadyCallback;
import com.mapquest.mapping.maps.MapboxMap;
import com.mapquest.mapping.maps.MapView;

public class MainActivity extends AppCompatActivity {
    private MapboxMap mMapboxMap;
    private MapView mMapView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        MapQuestAccountManager.start(getApplicationContext());

        setContentView(R.layout.activity_main);

        mMapView = (MapView) findViewById(R.id.mapquestMapView);
        mMapView.onCreate(savedInstanceState);

        mMapView.getMapAsync(new OnMapReadyCallback() {
            @Override
            public void onMapReady(MapboxMap mapboxMap) {
                mMapboxMap = mapboxMap;

                // create points
				LatLng imt_i8 = new LatLng(48.356356, -4.570593);
				LatLng tour = new LatLng(48.383421, -4.497139);
				LatLng jardin = new LatLng(48.381615, -4.499135);
				LatLng tram = new LatLng(48.384105, -4.499425);

                // center map
                mMapboxMap.moveCamera(CameraUpdateFactory.newLatLngZoom(tour, 17));

                // put points in map
                addMarker(mMapboxMap, tour, "tour", "tour HU3");
                addMarker(mMapboxMap, jardin, "jardin", "jardin HU3");
                addMarker(mMapboxMap, tram, "tram", "tram HU3");
            }
        });
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
}

