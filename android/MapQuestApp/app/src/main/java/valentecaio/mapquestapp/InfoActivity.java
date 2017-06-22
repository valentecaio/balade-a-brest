package valentecaio.mapquestapp;

import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.ImageView;

public class InfoActivity extends AppCompatActivity {
    ImageView photo;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_info);

        Point target = GlobalVariables.getInstance().target;
        photo.setVisibility(View.VISIBLE);
    }

}
