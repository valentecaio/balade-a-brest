package valentecaio.osm_example;

import android.content.ContentResolver;
import android.content.Context;
import android.content.pm.PackageManager;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.Build;
import android.os.Bundle;
import android.provider.Settings;
import android.support.v4.app.ActivityCompat;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;

import org.osmdroid.bonuspack.overlays.Marker;
import org.osmdroid.bonuspack.overlays.Polyline;
import org.osmdroid.bonuspack.routing.OSRMRoadManager;
import org.osmdroid.bonuspack.routing.Road;
import org.osmdroid.bonuspack.routing.RoadManager;
import org.osmdroid.tileprovider.tilesource.TileSourceFactory;
import org.osmdroid.tileprovider.tilesource.XYTileSource;
import org.osmdroid.util.GeoPoint;
import org.osmdroid.views.MapController;
import org.osmdroid.views.MapView;

import java.io.IOException;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.ArrayList;

import static org.osmdroid.ResourceProxy.string.offline_mode;

public class MainActivity extends AppCompatActivity implements LocationListener {
    private MapView mapView;
    private MapController mapController;
    private LocationManager lm;
    private boolean connection = true;
    private String TAG = "Debug";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        ask_permissions();

        // get references
        mapView = (MapView) this.findViewById(R.id.mapView);
        mapController = (MapController)this.mapView.getController();
        lm = (LocationManager) getSystemService(Context.LOCATION_SERVICE);

        init_map();

        // add point markers
        GeoPoint imt_i8 = new GeoPoint(48.356356, -4.570593);
        GeoPoint tour = new GeoPoint(48.383421, -4.497139);
        GeoPoint jardin = new GeoPoint(48.381615, -4.499135);
        GeoPoint tram = new GeoPoint(48.384105, -4.499425);
        addMarker(tour);
        addMarker(jardin);
        addMarker(tram);

        /*
        // create route from tour to jardin
        ArrayList<GeoPoint> waypoints = new ArrayList<GeoPoint>();
        waypoints.add(tour);
        waypoints.add(jardin);
        create_route(tour, jardin);
        */

        // start to listen to location changes
        if (displayGpsStatus()) {
            Context context = getApplicationContext();
            // check permission
            if ( Build.VERSION.SDK_INT >= 23 &&
                    ContextCompat.checkSelfPermission(context, android.Manifest.permission.ACCESS_FINE_LOCATION ) != PackageManager.PERMISSION_GRANTED &&
                    ContextCompat.checkSelfPermission(context, android.Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
                return  ;
            }
            lm.requestLocationUpdates(LocationManager.GPS_PROVIDER, 0, 0, this);
        }
    }

    // create a route
    // extracted from tutorial https://github.com/MKergall/osmbonuspack/wiki/Tutorial_1
    private void create_route(ArrayList<GeoPoint> waypoints){
        // create route
        RoadManager roadManager = new OSRMRoadManager();
        Road road = roadManager.getRoad(waypoints);

        // draw route in the map
        Polyline roadOverlay = RoadManager.buildRoadOverlay(road, this.getApplicationContext());
        mapView.getOverlays().add(roadOverlay);

        // refresh map
        mapView.invalidate();
    }

    private void init_map(){
        // config mapview
        mapView.setMultiTouchControls(true);
        mapView.setBuiltInZoomControls(true);
        mapController.setZoom(15);

        //connection = hasInternetAccess(this.getApplicationContext());
        if(connection){
            // online map
            mapView.setTileSource(TileSourceFactory.MAPNIK);
        } else {
            // offline map
            // the file osmdroid/brest-map.zip must exist in the phone
            XYTileSource tileSource = new XYTileSource("brest-map", offline_mode, 15, 17, 256, ".png", new String[]{});
            mapView.setTileSource(tileSource);
            mapView.setUseDataConnection(false); // prevent loading from the network
        }

        // moving map to a point
        GeoPoint point_to_center = new GeoPoint(48.385648, -4.501484);
        setMapCenter(point_to_center);

        // move with animation
        // mapController.animateTo(startPoint);
    }

    private void ask_permissions(){
        String[] permissions = {android.Manifest.permission.ACCESS_COARSE_LOCATION,
                android.Manifest.permission.ACCESS_FINE_LOCATION,
                android.Manifest.permission.INTERNET,
                android.Manifest.permission.ACCESS_NETWORK_STATE,
                android.Manifest.permission.WRITE_EXTERNAL_STORAGE,
                android.Manifest.permission.ACCESS_WIFI_STATE};
        ActivityCompat.requestPermissions( this, permissions, 0);
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

    // check if there is an active network
    // return true even if this network hasn't internet connection
    private boolean isNetworkAvailable() {
        ConnectivityManager connectivityManager
                = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo activeNetworkInfo = connectivityManager.getActiveNetworkInfo();
        return activeNetworkInfo != null;
    }

    // check if there is an active network connected to internet
    // return true ONLY if this network has internet connection
	// found it on http://stackoverflow.com/questions/6493517/detect-if-android-device-has-internet-connection
    public boolean hasInternetAccess(Context context) {
        if (isNetworkAvailable()) {
            try {
                HttpURLConnection urlc = (HttpURLConnection)
                        (new URL("http://clients3.google.com/generate_204")
                                .openConnection());
                urlc.setRequestProperty("User-Agent", "Android");
                urlc.setRequestProperty("Connection", "close");
                urlc.setConnectTimeout(1500);
                urlc.connect();
                return (urlc.getResponseCode() == 204 &&
                        urlc.getContentLength() == 0);
            } catch (IOException e) {
                Log.e(TAG, "Error checking internet connection", e);
            }
        } else {
            Log.d(TAG, "No network available!");
        }
        return false;
    }

    public void addMarker(GeoPoint center){
        Marker marker = new Marker(this.mapView);
        marker.setPosition(center);
        marker.setAnchor(Marker.ANCHOR_CENTER, Marker.ANCHOR_BOTTOM);

        // refresh marker in map
        mapView.getOverlays().add(marker);

        // refresh map
        mapView.invalidate();
    }

    // TODO: correct map center positioning
    public void setMapCenter(GeoPoint center){
        int width = mapView.getWidth();
        int height = mapView.getHeight();
        int zoom = mapView.getZoomLevel();

        Log.v("Debug", "map: w " + width + " h " + height + " z " + zoom);

        // this calculus must be changed and may use width, height and zoom
        double x = center.getLatitude();
        double y = center.getLongitude();

        GeoPoint new_center = new GeoPoint(x, y);
        mapController.setCenter(new_center);
    }

    @Override
    public void onLocationChanged(Location location) {
        Log.v("Debug", "Location changed to " + location.toString());
        GeoPoint center = new GeoPoint(location);
        addMarker(center);
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
