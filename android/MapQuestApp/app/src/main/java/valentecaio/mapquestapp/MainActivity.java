package valentecaio.mapquestapp;

import android.Manifest;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.provider.MediaStore;
import android.support.v4.app.ActivityCompat;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;

import com.mapbox.mapboxsdk.annotations.MarkerOptions;
import com.mapbox.mapboxsdk.camera.CameraUpdateFactory;
import com.mapbox.mapboxsdk.constants.MyLocationTracking;
import com.mapbox.mapboxsdk.geometry.LatLng;
import com.mapquest.mapping.MapQuestAccountManager;
import com.mapquest.mapping.maps.OnMapReadyCallback;
import com.mapquest.mapping.maps.MapboxMap;
import com.mapquest.mapping.maps.MapView;

import static com.mapquest.mapping.R.styleable.MapView;

public class MainActivity extends AppCompatActivity implements View.OnClickListener {
    private MapboxMap mMapboxMap;
    private MapView mMapView;
    private Button camera;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        MapQuestAccountManager.start(getApplicationContext());

        setContentView(R.layout.activity_main);

        //ask_permissions();
        camera = (Button) findViewById(R.id.camera_button);
        camera.setOnClickListener(this);

        mMapView = (MapView) findViewById(R.id.mapquestMapView);

        mMapView.onCreate(savedInstanceState);

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

                // center map
                mMapboxMap.moveCamera(CameraUpdateFactory.newLatLngZoom(d1_128b, 17));

                // put points in map
                addMarker(mMapboxMap, tour, "tour", "tour HU3");
                addMarker(mMapboxMap, jardin, "jardin", "jardin HU3");
                addMarker(mMapboxMap, tram, "tram", "tram HU3");
                addMarker(mMapboxMap, quarto_yan, "quarto yan", "partiu soiree");
                addMarker(mMapboxMap, laverie, "laverie", "bora roubar meia");
                addMarker(mMapboxMap, d1_128b, "d1_128b", "d1_128b");
            }
        });
    }

    private void enableUserTracking(MapboxMap mMapboxMap) {
        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED &&
                ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            return;
        }
        mMapboxMap.setMyLocationEnabled(true);
    }

    private void ask_permissions(){
        String[] permissions = {
                android.Manifest.permission.ACCESS_COARSE_LOCATION,
                android.Manifest.permission.ACCESS_FINE_LOCATION,
                android.Manifest.permission.INTERNET,
                android.Manifest.permission.ACCESS_NETWORK_STATE,
                android.Manifest.permission.WRITE_EXTERNAL_STORAGE,
                android.Manifest.permission.ACCESS_WIFI_STATE};
        ActivityCompat.requestPermissions(this, permissions, 0);
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
        Intent i=new Intent(this, CameraActivity.class);
        startActivity(i);
    }
}

