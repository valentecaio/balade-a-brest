package valentecaio.mapquestapp;

import android.content.Intent;
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
}
