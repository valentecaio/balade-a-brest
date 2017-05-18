package valentecaio.mapquestapp;

import android.content.Intent;
import android.content.pm.PackageManager;
import android.support.v4.app.ActivityCompat;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Adapter;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ListView;
import android.widget.Toast;

import java.util.ArrayList;
import java.util.Arrays;

public class StrollActivity extends AppCompatActivity {

    private ListView scrolls_LV;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_stroll);

        configureListView();

        verify_permissions();
    }

    public void configureListView(){
        scrolls_LV = (ListView)findViewById(R.id.scrolls_list_view);
        scrolls_LV.setOnItemClickListener(new ListView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view,
                                    int position, long id) {
                Log.i("debug", "Click ListItem Number " + position);

                Intent i = new Intent(StrollActivity.this, MapActivity.class);
                startActivity(i);
            }
        });

        String[] strolls = new String[] {"Telecom i8", "Telecom ecole", "Recouvrance"};
        final ArrayAdapter adapter = new ArrayAdapter(this, android.R.layout.simple_list_item_1, strolls);
        scrolls_LV.setAdapter(adapter);
    }

    private void verify_permissions(){
        String[] permissions = {
                android.Manifest.permission.ACCESS_COARSE_LOCATION,
                android.Manifest.permission.ACCESS_FINE_LOCATION,
                android.Manifest.permission.INTERNET,
                android.Manifest.permission.ACCESS_NETWORK_STATE,
                android.Manifest.permission.WRITE_EXTERNAL_STORAGE,
                android.Manifest.permission.ACCESS_WIFI_STATE,
                android.Manifest.permission.CAMERA};

        ArrayList<String> permissionsToAsk = new ArrayList<String>();
        for(String permission: permissions){
            if(ActivityCompat.checkSelfPermission(this, permission) != PackageManager.PERMISSION_GRANTED){
                permissionsToAsk.add(permission);
            }
        }

        // ask permission
        if (permissionsToAsk.size() > 0) {
            String[] request = new String[permissionsToAsk.size()];
            request = permissionsToAsk.toArray(request);
            ActivityCompat.requestPermissions(this, request, 1);
        }
    }
}
