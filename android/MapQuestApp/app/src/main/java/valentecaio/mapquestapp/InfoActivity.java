package valentecaio.mapquestapp;

import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;

import java.util.ArrayList;

public class InfoActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_info);

        Point target = GlobalVariables.getInstance().target;
        TextView descript_tv = (TextView) findViewById(R.id.description_textView);
        descript_tv.setText(target.toString() + "\n" + target.getDescription());
        descript_tv.setVisibility(View.INVISIBLE);

        configureListView();
    }

    public void configureListView(){
        final ListView balades_listView = (ListView)findViewById(R.id.info_list_view);
        balades_listView.setItemsCanFocus(false);

        // set onclick listener to listView rows
        balades_listView.setOnItemClickListener(new ListView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view,
                                    int position, long id) {
                Log.i("ONCLICK_CELL", "Click ListItem Number " + position);

            }
        });

        // populate listView
        ArrayList<String> medias = GlobalVariables.getInstance().target.getMedias();
        final ArrayAdapter adapter = new ArrayAdapter(this, android.R.layout.simple_list_item_1, medias);
        balades_listView.setAdapter(adapter);
    }

}
