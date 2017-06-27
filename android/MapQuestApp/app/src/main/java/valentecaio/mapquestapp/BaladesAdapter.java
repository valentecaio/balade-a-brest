package valentecaio.mapquestapp;

import android.content.Context;
import android.graphics.Color;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.TextView;

import java.util.ArrayList;

/**
 * Created by caio on 19/6/2017.
 * Followed the example https://github.com/codepath/android_guides/wiki/Using-an-ArrayAdapter-with-ListView
 */

public class BaladesAdapter extends ArrayAdapter<Balade> {
    StrollActivity delegate;

    public BaladesAdapter(Context context, ArrayList<Balade> balades, StrollActivity delegate) {
        super(context, 0, balades);
        this.delegate = delegate;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        // Get the data item for this position
        Balade balade = getItem(position);

        // Check if an existing view is being reused, otherwise inflate the view
        if (convertView == null) {
            convertView = LayoutInflater.from(getContext()).inflate(R.layout.item_balade, parent, false);
        }

        // Lookup view for data population
        TextView tvName = (TextView) convertView.findViewById(R.id.tvName);
        // Populate the data into the template view using the data object
        tvName.setText(balade.getName());

        // config download button
        Button butDownload = (Button) convertView.findViewById(R.id.butDownload);
        DownloadButtonListener listener = new DownloadButtonListener(balade, this.delegate);
        butDownload.setOnClickListener(listener);

        // do not focus to avoid losing touchs
        butDownload.setFocusable(false);
        butDownload.setFocusableInTouchMode(false);

        // set background
        convertView.setBackgroundColor(baladeIsLocal(balade) ? Color.CYAN : Color.LTGRAY);

        // Return the completed view to render on screen
        return convertView;
    }

    private boolean baladeIsLocal(Balade balade){
        for(Balade localBalade: delegate.getLocalBalades()){
            if(localBalade.getId() == balade.getId())
                return true;
        }
        return false;
    }
}