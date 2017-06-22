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

public class DatabaseQueryAsync extends AsyncTask<Void, Void, String> {
    private DAO delegate;
    private String hostname;
    private String query_filename;

    public DatabaseQueryAsync(DAO delegate, String hostname, String query_filename) {
        super();
        this.delegate = delegate;
        this.hostname = hostname;
        this.query_filename = query_filename;
    }

    @Override
    protected String doInBackground(Void... params) {
        String JSON_URL = hostname + query_filename;
        Log.d("QUERY", "created a query from file: " + JSON_URL);
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
    protected void onPostExecute(String result) {
        Log.d("QUERY", "query returned: " + result);
        delegate.parseQueryResult(result);
    }

    @Override
    protected void onPreExecute() {
        super.onPreExecute();
    }

    @Override
    protected void onProgressUpdate(Void... values) {
        super.onProgressUpdate(values);
    }
}
