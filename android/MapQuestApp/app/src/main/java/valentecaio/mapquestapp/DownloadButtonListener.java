package valentecaio.mapquestapp;

import android.app.Activity;
import android.util.Log;
import android.view.View;

/**
 * Created by caio on 19/6/2017.
 */

public class DownloadButtonListener implements View.OnClickListener {
    Balade balade;
    AppFileManager afm;
    StrollActivity delegate;

    public DownloadButtonListener(Balade balade, StrollActivity delegate) {
        this.balade = balade;
        this.delegate = delegate;
        this.afm = new AppFileManager(delegate.getApplication().getApplicationContext());
    }

    @Override
    public void onClick(View view) {
        Log.i("ONCLICK", "Downloading balade: " + balade.toString());
        delegate.database.downloadBalade(this.balade);
    }
}
