package valentecaio.osm_example;

import android.content.ContentResolver;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.provider.Settings;
import android.support.v4.app.ActivityCompat;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;

import org.osmdroid.bonuspack.overlays.Marker;
import org.osmdroid.tileprovider.tilesource.TileSourceFactory;
import org.osmdroid.util.GeoPoint;
import org.osmdroid.views.MapController;
import org.osmdroid.views.MapView;

public class MainActivity extends AppCompatActivity implements LocationListener {
    private MapView mapView;
    private MapController mapController;
    private LocationManager lm;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        // get permissions
        String[] permissions = {android.Manifest.permission.ACCESS_COARSE_LOCATION,
                android.Manifest.permission.ACCESS_FINE_LOCATION,
                android.Manifest.permission.INTERNET,
                android.Manifest.permission.ACCESS_NETWORK_STATE,
                android.Manifest.permission.WRITE_EXTERNAL_STORAGE,
                android.Manifest.permission.ACCESS_WIFI_STATE};
        ActivityCompat.requestPermissions( this, permissions, 0);

        // creating mapview
        mapView = (MapView) this.findViewById(R.id.mapView);
        mapView.setTileSource(TileSourceFactory.MAPNIK);
        mapView.setBuiltInZoomControls(true);
        mapView.setMultiTouchControls(true);

        // getting mapview controller
        mapController = (MapController)this.mapView.getController();
        mapController.setZoom(2);

        // moving map to a point
        GeoPoint imt = new GeoPoint(48.356356, -4.570593);
        mapController.setCenter(imt);
        refreshMarker(imt);
        // move with animation
        // mapController.animateTo(startPoint);

    }

    /*----Method to Check GPS is enable or disable ----- */
    private Boolean displayGpsStatus() {
        ContentResolver contentResolver = getBaseContext()
                .getContentResolver();
        boolean gpsStatus = Settings.Secure
                .isLocationProviderEnabled(contentResolver,
                        LocationManager.GPS_PROVIDER);
        return gpsStatus;
    }

    public void refreshMarker(GeoPoint center){
        Marker marker = new Marker(this.mapView);
        marker.setPosition(center);
        marker.setAnchor(Marker.ANCHOR_CENTER, Marker.ANCHOR_BOTTOM);

        // refresh marker in map
        mapView.getOverlays().clear();
        mapView.getOverlays().add(marker);

        // refresh map
        mapView.invalidate();
    }

    @Override
    public void onLocationChanged(Location location) {

    }

    @Override
    public void onStatusChanged(String provider, int status, Bundle extras) {

    }

    @Override
    public void onProviderEnabled(String provider) {

    }

    @Override
    public void onProviderDisabled(String provider) {

    }

    @Override
    public void onDestroy(){
        super.onDestroy();
        if (lm != null){
            try {
                lm.removeUpdates(this);
            } catch (SecurityException ex){
                System.out.println(ex.toString());
            }

        }
    }
}
