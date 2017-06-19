package valentecaio.mapquestapp;

/**
 * Created by caio on 19/6/2017.
 */

public class GlobalVariables {
    private static GlobalVariables mInstance= null;

    public static Balade balade;
    public static Point target;

    protected GlobalVariables(){}

    public static synchronized GlobalVariables getInstance(){
        if(null == mInstance){
            mInstance = new GlobalVariables();
        }
        return mInstance;
    }
}
