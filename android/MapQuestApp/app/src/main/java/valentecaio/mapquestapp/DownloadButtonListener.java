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

    public DownloadButtonListener(Balade balade, Activity delegate) {
        this.balade = balade;
        afm = new AppFileManager(delegate.getApplication().getApplicationContext());
    }

    @Override
    public void onClick(View view) {
        Log.i("onClick", "Downloading balade: " + balade.toString());
        Balade b = DAO.fake_downloadBalade(this.balade.getId());
        afm.writeBalade(b);

        afm.setName("balade_" + b.getId() + ".csv");
        String csv = afm.read();
        Log.i("written data", csv);
    }
}
