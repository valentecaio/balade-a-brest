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

import java.io.IOException;

import static valentecaio.mapquestapp.R.id.camera_view;

public class CameraActivity extends AppCompatActivity implements SurfaceHolder.Callback, SensorEventListener {

    private Camera mCamera;
    private SurfaceHolder mSurfaceHolder;
    private boolean isCameraviewOn = false ;

    float[] mGravity;
    float[] mGeomagnetic;
    float azimut;
    float degree;
    Sensor magnetometer;
    Sensor accelerometer;
    SensorManager sensorManager;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_camera);

        verifyCameraPermissions();

        // config camera
        SurfaceView surfaceView = (SurfaceView) findViewById(camera_view);
        mSurfaceHolder = surfaceView.getHolder();
        mSurfaceHolder.addCallback( this );
        mSurfaceHolder.setType(SurfaceHolder.SURFACE_TYPE_PUSH_BUFFERS);

        // config compass
        sensorManager = (SensorManager) getSystemService(SENSOR_SERVICE);
        magnetometer = sensorManager.getDefaultSensor(Sensor.TYPE_ACCELEROMETER);
        accelerometer = sensorManager.getDefaultSensor(Sensor.TYPE_MAGNETIC_FIELD);
        sensorManager.registerListener(this, magnetometer, SensorManager.SENSOR_DELAY_GAME);
        sensorManager.registerListener(this, accelerometer, SensorManager.SENSOR_DELAY_GAME);
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
                // orientation contains azimut, pitch and roll
                float orientation[] = new float[3];
                SensorManager.getOrientation(R, orientation);

                azimut = orientation[0];
                degree = (float)(Math.toDegrees(azimut)+360)%360;
                Log.v("DEBUG", "azimut = " + azimut + " with degree = " + degree);
            }
        }
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
}

