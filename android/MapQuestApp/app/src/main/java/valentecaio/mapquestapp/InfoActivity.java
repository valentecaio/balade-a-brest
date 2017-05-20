package valentecaio.mapquestapp;

import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;
import android.widget.ImageView;

public class InfoActivity extends AppCompatActivity {

    ImageView photo;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_info);

        String point_id = getIntent().getStringExtra("id");
        Log.i("point id", point_id);
        if(point_id.equals("departement informatique"))
            photo = (ImageView) findViewById(R.id.imt6);
        else if(point_id.equals("centre vie"))
            photo = (ImageView) findViewById(R.id.imt2);
        else if(point_id.equals("departement des langues"))
            photo = (ImageView) findViewById(R.id.imt4);
        else if(point_id.equals("salle meridianne"))
            photo = (ImageView) findViewById(R.id.imt5);
        else
            photo = (ImageView) findViewById(R.id.imt1);
        photo.setVisibility(View.VISIBLE);
    }

}
