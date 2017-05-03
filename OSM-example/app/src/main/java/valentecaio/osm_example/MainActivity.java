package valentecaio.osm_example;

import android.content.ContentResolver;
import android.content.Context;
import android.content.pm.PackageManager;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.Build;
import android.os.Bundle;
import android.provider.Settings;
import android.support.v4.app.ActivityCompat;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;

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

        // get references
        mapView = (MapView) this.findViewById(R.id.mapView);
        mapController = (MapController)this.mapView.getController();
        lm = (LocationManager) getSystemService(Context.LOCATION_SERVICE);

        // config mapview
        mapView.setTileSource(TileSourceFactory.MAPNIK);
        mapView.setBuiltInZoomControls(true);
        mapView.setMultiTouchControls(true);

        // config mapview controller
        mapController.setZoom(12);

        // moving map to a point
        GeoPoint imt = new GeoPoint(48.356356, -4.570593);
        mapController.setCenter(imt);
        refreshMarker(imt);
        // move with animation
        // mapController.animateTo(startPoint);

        // start to listen to location changements
        if (displayGpsStatus()) {
            Context context = getApplicationContext();
            // check permission
            if ( Build.VERSION.SDK_INT >= 23 &&
                    ContextCompat.checkSelfPermission(context, android.Manifest.permission.ACCESS_FINE_LOCATION ) != PackageManager.PERMISSION_GRANTED &&
                    ContextCompat.checkSelfPermission(context, android.Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
                Log.v("Debug", "returning with SDK version " + Build.VERSION.SDK_INT);
                return  ;
            }
            lm.requestLocationUpdates(LocationManager.GPS_PROVIDER, 0, 0, this);
        }
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
        Log.v("Debug", "Location changed to " + location.toString());
        GeoPoint center = new GeoPoint(location);
        refreshMarker(center);
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
