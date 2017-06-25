package valentecaio.mapquestapp;

import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

public class InfoActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_info);

        Point target = GlobalVariables.getInstance().target;
        TextView descript_tv = (TextView) findViewById(R.id.description_textView);
        descript_tv.setText(target.toString() + "\n" + target.getDescription());
    }

}
