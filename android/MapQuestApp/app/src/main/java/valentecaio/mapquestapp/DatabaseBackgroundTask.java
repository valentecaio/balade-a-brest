package valentecaio.mapquestapp;

import android.os.AsyncTask;
import android.util.Log;

import java.io.BufferedReader;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;

/**
 * Created by caio on 21/6/2017.
 */

public class DatabaseBackgroundTask extends AsyncTask<Void, Void, String> {
    private String JSON_URL;

    private DAO delegate;
    private String query_filename;
    private String hostname;

    public DatabaseBackgroundTask(DAO delegate, String query_filename, String hostname) {
        super();
        this.delegate = delegate;
        this.query_filename = query_filename;
        this.hostname = hostname;
    }

    @Override
    protected void onPreExecute() {
        JSON_URL = hostname + query_filename;
    }

    @Override
    protected String doInBackground(Void... params) {
        try {
            StringBuilder JSON_DATA = new StringBuilder();
            URL url = new URL(JSON_URL);
            HttpURLConnection httpURLConnection = (HttpURLConnection) url.openConnection();
            InputStream in = httpURLConnection.getInputStream();
            BufferedReader reader = new BufferedReader(new InputStreamReader(in));
            while ((delegate.JSON_STRING = reader.readLine()) != null) {
                JSON_DATA.append(delegate.JSON_STRING).append("\n");
            }
            return JSON_DATA.toString().trim();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return null;
    }

    @Override
    protected void onProgressUpdate(Void... values) {
        super.onProgressUpdate(values);
    }

    @Override
    protected void onPostExecute(String result) {
        delegate.parseResult(result);
    }
}
