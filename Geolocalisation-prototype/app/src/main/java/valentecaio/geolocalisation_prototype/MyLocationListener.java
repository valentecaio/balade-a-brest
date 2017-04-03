package valentecaio.geolocalisation_prototype; /**
 * Created by caio on 03/04/2017.
 */

import android.content.Context;
import android.location.Address;
import android.location.Geocoder;
import android.location.Location;
import android.location.LocationListener;
import android.os.Bundle;
import android.util.Log;

import java.io.IOException;
import java.util.List;
import java.util.Locale;


/*----------Listener class to get coordinates ------------- */
public class MyLocationListener implements LocationListener {

    private Context context;

    public MyLocationListener(Context context) {
        this.context = context;
    }

    @Override
    public void onLocationChanged(Location loc) {
        String longitude = "Longitude: " +loc.getLongitude();
        Log.v("Debug", longitude);
        String latitude = "Latitude: " +loc.getLatitude();
        Log.v("Debug", latitude);

    /*----------to get City-Name from coordinates ------------- */
        String cityName=null;
        Geocoder gcd = new Geocoder(context, Locale.getDefault());
        List<Address> addresses;
        try {
            addresses = gcd.getFromLocation(loc.getLatitude(), loc
                    .getLongitude(), 1);
            if (addresses.size() > 0)
                cityName=addresses.get(0).getLocality();
                Log.v("Debug", "My Currrent City is: " + cityName);
                Place p = new Place(loc.getLongitude(), loc.getLatitude(), cityName);
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    @Override
    public void onProviderDisabled(String provider) {
        // TODO Auto-generated method stub
    }

    @Override
    public void onProviderEnabled(String provider) {
        // TODO Auto-generated method stub
    }

    @Override
    public void onStatusChanged(String provider,
                                int status, Bundle extras) {
        // TODO Auto-generated method stub
    }
}
