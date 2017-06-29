package valentecaio.mapquestapp;

import android.location.Location;

/**
 * Created by caio on 19/6/2017.
 */

public class GlobalVariables {
    private static GlobalVariables mInstance= null;

    public static Balade balade;
    public static Point target;
    public static Location userLocation;
    public static String MEDIAS_FILEPATH = "sdcard/balade_a_brest/";
    public static boolean DEBUG = false;

    protected GlobalVariables(){}

    public static synchronized GlobalVariables getInstance(){
        if(null == mInstance){
            mInstance = new GlobalVariables();
        }
        return mInstance;
    }
}
