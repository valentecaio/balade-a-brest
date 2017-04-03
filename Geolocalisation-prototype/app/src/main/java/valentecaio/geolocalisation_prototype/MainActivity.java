package valentecaio.geolocalisation_prototype;

import android.content.ContentResolver;
import android.content.Context;
import android.content.pm.PackageManager;
import android.location.LocationManager;
import android.os.Build;
import android.os.Bundle;
import android.provider.Settings;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v4.app.ActivityCompat;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;

public class MainActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        final LocationManager locationManager = (LocationManager) getSystemService(Context.LOCATION_SERVICE);

        // request permission to user
        if ( ContextCompat.checkSelfPermission( this,
                android.Manifest.permission.ACCESS_COARSE_LOCATION ) != PackageManager.PERMISSION_GRANTED ) {

            int MIN_DISTANCE_CHANGE_FOR_UPDATES = 0;
            ActivityCompat.requestPermissions( this, new String[] {  android.Manifest.permission.ACCESS_COARSE_LOCATION  },
                    MIN_DISTANCE_CHANGE_FOR_UPDATES  );
        }

        FloatingActionButton fab = (FloatingActionButton) findViewById(R.id.fab);
        fab.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View view) {
                Log.v("Debug", "onClick");
                if (displayGpsStatus()) {
                    Context context = getApplicationContext();
                    MyLocationListener locationListener = new MyLocationListener(context);

                    // check permission
                    if ( Build.VERSION.SDK_INT >= 23 &&
                            ContextCompat.checkSelfPermission( context, android.Manifest.permission.ACCESS_FINE_LOCATION ) != PackageManager.PERMISSION_GRANTED &&
                            ContextCompat.checkSelfPermission( context, android.Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
                        Log.v("Debug", "returning with SDK version " + Build.VERSION.SDK_INT);
                        return  ;
                    }

                    locationManager.requestLocationUpdates(LocationManager
                            .GPS_PROVIDER, 5000, 10,locationListener);

                } else {
                    Log.v("Debug", "Gps Status!! Your GPS is: OFF");
                }
                Snackbar.make(view, "Replace with your own action", Snackbar.LENGTH_LONG)
                        .setAction("Action", null).show();

            }
        });

    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
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

}
