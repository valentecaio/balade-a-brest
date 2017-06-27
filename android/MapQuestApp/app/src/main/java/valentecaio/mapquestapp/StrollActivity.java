package valentecaio.mapquestapp;

import android.content.Intent;
import android.content.pm.PackageManager;
import android.graphics.Color;
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
    private ArrayList<Balade> serverBalades;
    private ArrayList<Balade> localBalades = new ArrayList<>();
    private ArrayList<Balade> lv_source;
    public DAO database = new DAO(this);
    public AppFileManager afm;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_stroll);

        verify_permissions();

        afm = new AppFileManager(getApplicationContext());

        // uncomment following line to delete all data when loading application
        //afm.deleteAll();

        // read all balades from internal database
        localBalades = afm.listDownloadedBalades();


        // disable buttons before requesting data to database
        this.enableButtons(false);
        // load database to populate listView
        this.database.loadDatabase();

        configureListView();
    }

    public void configureListView(){
        this.balades_listView = (ListView)findViewById(R.id.scrolls_list_view);
        balades_listView.setItemsCanFocus(false);

        // if cant load serverBalades, show only localBalades
        this.lv_source = serverBalades!=null ? serverBalades : localBalades;

        balades_listView.setOnItemClickListener(new ListView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view,
                                    int position, long id) {
                Log.i("ONCLICK_CELL", "Click ListItem Number " + position);

                // stock clicked balade as global variables
                Balade chosen_balade = lv_source.get(position);

                // try/catch to avoid error when clicking in not downloaded balade
                try {
                    // load balade points/medias before performing intent
                    chosen_balade = afm.readBalade(chosen_balade.getId());
                    GlobalVariables.getInstance().balade = chosen_balade;

                    // go to mapActivity
                    Intent i = new Intent(StrollActivity.this, MapActivity.class);
                    startActivity(i);
                } catch (Exception e) {
                    e.printStackTrace();
                }
            }
        });

        // populate listView
        BaladesAdapter adapter = new BaladesAdapter(this, lv_source, this);
        balades_listView.setAdapter(adapter);
    }

    public void setBaladesArray(ArrayList<Balade> balades){
        // useful information for debug
        for(Balade b: balades){
            Log.i("STROLL_ACTIVITY", b.toString());
        }

        this.serverBalades = balades;
        configureListView();
    }

    public void enableButtons(boolean enabled) {
        Log.i("ENABLE_BUTTONS", "" + enabled);
    }

    public void signalBaladeDownloadFinished(Balade b) {
        changeCellColor(b, Color.CYAN);
    }

    public void changeCellColor(Balade balade, int color){
        int cell_index = this.lv_source.indexOf(balade);
        Log.i("STROLL_ACTIVITY", "changing color of cell index: " + cell_index);
        if(cell_index >= 0)
            this.balades_listView.getChildAt(cell_index).setBackgroundColor(color);
    }

    public ArrayList<Balade> getLocalBalades() {
        return localBalades;
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
