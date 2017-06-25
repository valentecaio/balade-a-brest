package valentecaio.mapquestapp;

import android.app.Activity;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;
import android.webkit.MimeTypeMap;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;

import com.google.common.io.ByteStreams;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.util.ArrayList;

public class InfoActivity extends AppCompatActivity {
    ArrayList<String> medias = new ArrayList<>();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_info);

        Point target = GlobalVariables.getInstance().target;
        TextView descript_tv = (TextView) findViewById(R.id.description_textView);
        descript_tv.setText(target.toString() + "\n" + target.getDescription());
        descript_tv.setVisibility(View.INVISIBLE);
        Log.i("INFO_ACTIVITY", "target: " + target.toString());

        configureListView();
    }

    public void configureListView(){
        final ListView balades_listView = (ListView)findViewById(R.id.info_list_view);
        balades_listView.setItemsCanFocus(false);

        // populate listView
        this.medias = GlobalVariables.getInstance().target.getMedias();
        final ArrayAdapter adapter = new ArrayAdapter(this, android.R.layout.simple_list_item_1, medias);
        balades_listView.setAdapter(adapter);

        for(String m: this.medias){
            Log.i("INFO_ACTIVITY", "media " + m);
        }

        // set onclick listener to listView rows
        balades_listView.setOnItemClickListener(new ListView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view,
                                    int position, long id) {
                Log.i("ONCLICK_CELL", "Click ListItem Number " + position);

                String filename = medias.get(position);
                String filesDir = GlobalVariables.getInstance().MEDIAS_FILEPATH;
                String extension = getFileExtension(filename);
                File media = new File(filesDir + filename);

                String mime = MimeTypeMap.getSingleton().getMimeTypeFromExtension(extension);
                Log.i("INFO_ACTIVITY", "mime: " + mime + ", file: " + media.getAbsolutePath());

                Intent mediaIntent = new Intent(Intent.ACTION_VIEW);
                mediaIntent.setDataAndType(Uri.fromFile(media), mime);
                mediaIntent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(mediaIntent);
            }
        });
    }

    private String getFileExtension(String filename) {
        String extension = "";

        int i = filename.lastIndexOf('.');
        if (i > 0) {
            return filename.substring(i + 1);
        }
        return null;
    }
}
