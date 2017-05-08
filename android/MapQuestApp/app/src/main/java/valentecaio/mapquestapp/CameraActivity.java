package valentecaio.mapquestapp;

import android.Manifest;
import android.content.pm.PackageManager;
import android.hardware.Camera;
import android.hardware.Sensor;
import android.hardware.SensorEvent;
import android.hardware.SensorEventListener;
import android.hardware.SensorManager;
import android.os.Bundle;
import android.support.v4.app.ActivityCompat;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.SurfaceHolder;
import android.view.SurfaceView;
import android.widget.TextView;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import static valentecaio.mapquestapp.R.id.camera_view;

public class CameraActivity extends AppCompatActivity implements SurfaceHolder.Callback, SensorEventListener {

    TextView descriptionTextView;

    private Camera mCamera;
    private SurfaceHolder mSurfaceHolder;
    private boolean isCameraviewOn = false ;

    float[] mGravity;
    float[] mGeomagnetic;
    float degree;
    Sensor magnetometer;
    Sensor accelerometer;
    SensorManager sensorManager;
    Point target;
    Point myLocation;

    private static final double DISTANCE_SAFETY_MARGIN = 20 ;
    private static final double AZIMUTH_SAFETY_MARGIN = 10 ;

    private double currentAzimuth = 0;
    private double targetAzimuth = 0;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_camera);

        verifyCameraPermissions();

        target = new Point("yan", 48.356609, -4.570390);
        myLocation = new Point("elnatan", 48.356647, -4.570205);
        descriptionTextView = (TextView) findViewById(R.id.cameraTextView);

        // TODO: do this when changing location
        recalculateTargetAzimuth();

        // config camera
        SurfaceView surfaceView = (SurfaceView) findViewById(camera_view);
        mSurfaceHolder = surfaceView.getHolder();
        mSurfaceHolder.addCallback(this);
        mSurfaceHolder.setType(SurfaceHolder.SURFACE_TYPE_PUSH_BUFFERS);

        // config compass
        sensorManager = (SensorManager) getSystemService(SENSOR_SERVICE);
        magnetometer = sensorManager.getDefaultSensor(Sensor.TYPE_ACCELEROMETER);
        accelerometer = sensorManager.getDefaultSensor(Sensor.TYPE_MAGNETIC_FIELD);
        sensorManager.registerListener(this, magnetometer, SensorManager.SENSOR_DELAY_GAME);
        sensorManager.registerListener(this, accelerometer, SensorManager.SENSOR_DELAY_GAME);
    }

    private void updateDescription() {
        long distance = (long) calculateDistance();
        int tAzimut = (int) targetAzimuth;
        int rAzimut = (int) degree;

        String text = target.getName() + " location:"
                + "\n latitude: " + target.getLatitude() + "  longitude: " + target.getLongitude()
                + "\n Current location:"
                + "\n Latitude: " + myLocation.getLatitude() + "  Longitude: " + myLocation.getLongitude()
                + "\n "
                + "\n Target currentAzimuth: " + tAzimut
                + "\n Current currentAzimuth: " + rAzimut
                + "\n Distance: " + distance;

        descriptionTextView.setText(text);
    }

    public void recalculateTargetAzimuth() {
        double dX = target.getLatitude() - myLocation.getLatitude();
        double dY = target.getLongitude() - myLocation.getLongitude();

        double phiAngle;
        double tanPhi;

        tanPhi = Math.abs(dY / dX);
        phiAngle = Math.atan(tanPhi);
        phiAngle = Math.toDegrees(phiAngle);

        if (dX > 0 && dY > 0) { // I quater
            targetAzimuth = phiAngle;
        } else if (dX < 0 && dY > 0) { // II
            targetAzimuth = 180 - phiAngle;
        } else if (dX < 0 && dY < 0) { // III
            targetAzimuth = 180 + phiAngle;
        } else if (dX > 0 && dY < 0) { // IV
            targetAzimuth = 360 - phiAngle;
        } else {
            targetAzimuth = phiAngle;
        }
    }

    @Override
    public void surfaceCreated(SurfaceHolder surfaceHolder) {
        mCamera = Camera. open();
        mCamera.setDisplayOrientation( 90);
    }

    @Override
    public void surfaceChanged(SurfaceHolder surfaceHolder, int i, int i1, int i2) {
        if (isCameraviewOn) {
            mCamera.stopPreview();
            isCameraviewOn = false ;
        }

        if ( mCamera != null ) {
            try {
                mCamera.setPreviewDisplay(mSurfaceHolder);
                mCamera.startPreview();
                isCameraviewOn = true ;
            } catch (IOException e) {
                e.printStackTrace();
            }
        }
    }

    @Override
    public void surfaceDestroyed(SurfaceHolder surfaceHolder) {
        mCamera.stopPreview();
        mCamera.release();
        mCamera = null ;
        isCameraviewOn = false ;
    }

    public  void verifyCameraPermissions() {
        String[] PERMISSIONS_STORAGE = {Manifest.permission.CAMERA};
        // Check if we have write permission
        int permission = ActivityCompat.checkSelfPermission(this, Manifest.permission.CAMERA);

        if (permission != PackageManager.PERMISSION_GRANTED) {
            // We don't have permission so prompt the user
            ActivityCompat.requestPermissions(this,PERMISSIONS_STORAGE,1);
        }
    }

    @Override
    public void onSensorChanged(SensorEvent event) {
        if (event.sensor.getType() == Sensor.TYPE_ACCELEROMETER) {
            //Log.v("DEBUG", "EVENT FROM ACCELEROMETER: " + event.values.toString());
            mGravity = event.values;
        }

        if (event.sensor.getType() == Sensor.TYPE_MAGNETIC_FIELD) {
            //Log.v("DEBUG", "EVENT FROM MAGNETIC_FIELD: " + event.values.toString());
            mGeomagnetic = event.values;
        }

        if (mGravity != null && mGeomagnetic != null) {
            float R[] = new float[9];
            float I[] = new float[9];

            if (SensorManager.getRotationMatrix(R, I, mGravity, mGeomagnetic)) {
                // orientation contains currentAzimuth, pitch and roll
                float orientation[] = new float[3];
                SensorManager.getOrientation(R, orientation);

                currentAzimuth = (double)orientation[0];
                degree = (float)(Math.toDegrees(currentAzimuth)+360)%360;
                Log.v("DEBUG", "currentAzimuth = " + currentAzimuth + " with degree = " + degree);

                updateDescription();
            }
        }
    }

    private List<Double> calculateAzimuthRange(double azimuth) {
        double minAngle = azimuth - AZIMUTH_SAFETY_MARGIN;
        double maxAngle = azimuth + AZIMUTH_SAFETY_MARGIN;
        List<Double> minMax = new ArrayList<Double>();

        if (minAngle < 0)
            minAngle += 360;

        if (maxAngle >= 360)
            maxAngle -= 360;

        minMax.clear();
        minMax.add(minAngle);
        minMax.add(maxAngle);

        return minMax;
    }

    @Override
    public void onAccuracyChanged(Sensor sensor, int i) {    }

    @Override
    protected void onResume() {
        super.onResume();
        sensorManager.registerListener(this, magnetometer, SensorManager.SENSOR_DELAY_GAME);
        sensorManager.registerListener(this, accelerometer, SensorManager.SENSOR_DELAY_GAME);
    }

    @Override
    protected void onPause() {
        super.onPause();
        sensorManager.unregisterListener(this);
    }

    public double calculateDistance() {
        double dX = target.getLatitude() - myLocation.getLatitude();
        double dY = target.getLongitude() - myLocation.getLongitude();

        double distance = (Math. sqrt(Math.pow (dX, 2 ) + Math.pow(dY, 2 )) * 100000 );

        return distance;
    }
}

