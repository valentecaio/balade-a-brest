package valentecaio.mapquestapp;

import android.util.Log;
import android.view.View;

/**
 * Created by caio on 19/6/2017.
 */

public class DownloadButtonListener implements View.OnClickListener {
    Balade balade;

    public DownloadButtonListener(Balade balade) {
        this.balade = balade;
    }

    @Override
    public void onClick(View view) {
        Log.i("onClick download button", "Downloading balade: " + balade.toString());
        DAO.fake_downloadBalade(this.balade.getId());
    }
}
