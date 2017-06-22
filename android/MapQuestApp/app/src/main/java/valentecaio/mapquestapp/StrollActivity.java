package valentecaio.mapquestapp;

import android.content.Intent;
import android.content.pm.PackageManager;
import android.os.Bundle;
import android.support.v4.app.ActivityCompat;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;

import java.util.ArrayList;

public class StrollActivity extends AppCompatActivity {
    private ListView balades_listView;
    private ArrayList<Balade> balades = new ArrayList<Balade>();
    private DAO database = new DAO(this);

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_stroll);

        configureListView();

        verify_permissions();

        // read all balades and points (useful to debug)
        new AppFileManager(this).readAll();

        database.readAllBalades();
    }

    public void configureListView(){
        balades_listView = (ListView)findViewById(R.id.scrolls_list_view);
        balades_listView.setOnItemClickListener(new ListView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view,
                                    int position, long id) {
                Log.i("debug", "Click ListItem Number " + position);

                // stock clicked balade as global variables
                Balade chosen_balade = balades.get(position);
                GlobalVariables.getInstance().balade = chosen_balade;

                // go to mapActivity
                Intent i = new Intent(StrollActivity.this, MapActivity.class);
                startActivity(i);
            }
        });

        // populate listView
        BaladesAdapter adapter = new BaladesAdapter(this, balades, this);
        balades_listView.setAdapter(adapter);
    }

    public void setBaladesArray(ArrayList<Balade> balades){
        this.balades = balades;
        configureListView();
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
