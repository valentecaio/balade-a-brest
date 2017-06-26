package valentecaio.mapquestapp;

import android.os.AsyncTask;
import android.util.Log;

import java.io.BufferedInputStream;
import java.io.FileOutputStream;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.URL;
import java.net.URLConnection;

public class DownloadMediasAsync extends AsyncTask<String, String, String> {
    Boolean isSDPresent = android.os.Environment.getExternalStorageState().equals(android.os.Environment.MEDIA_MOUNTED);

    private static String filesDir;
    private static String databaseFilesDir = "uploads/";

    private DAO delegate;
    private String hostname;
    private String filename;

    public DownloadMediasAsync(DAO delegate, String hostname, String filename) {
        this.delegate = delegate;
        this.hostname = hostname;
        this.filename = filename;
        this.filesDir = GlobalVariables.getInstance().MEDIAS_FILEPATH;
        //this.filesDir = delegate.delegate.getApplicationContext().getFilesDir().getAbsolutePath() + "/";
    }

    private String resp;

    @Override
    protected String doInBackground(String... params) {
        int count;

        String url_str = hostname + databaseFilesDir + filename;
        Log.i("DOWNLOAD_MEDIA", "downloading from " + url_str);
        try {
            URL url = new URL(url_str);
            URLConnection connection = url.openConnection();
            connection.connect();

            int lengthOfFile = connection.getContentLength();
            String fullpath = filesDir + filename;
            Log.i("DOWNLOAD_MEDIA", "length of " + filename + " : " + lengthOfFile);
            Log.i("DOWNLOAD_MEDIA", "saving at " + fullpath);

            resp = filename;

            OutputStream outputStream = new FileOutputStream(fullpath);
            InputStream inputStream = new BufferedInputStream(url.openStream());
            byte data[] = new byte[1024];
            long total = 0;
            while ((count = inputStream.read(data)) != -1) {
                total += count;
                publishProgress("" + (int) ((total * 100) / lengthOfFile));
                outputStream.write(data, 0, count);
            }

            outputStream.flush();
            outputStream.close();
            inputStream.close();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return resp;
    }

    @Override
    protected void onPostExecute(String filename) {
        Log.i("DOWNLOAD_MEDIA", "finished the download of " + filename);
        delegate.onFinishMediaDownload(filename);
    }

    @Override
    protected void onProgressUpdate(String... values) {
        Log.d("DOWNLOAD_MEDIA", values[0] + "% done");
    }

    @Override
    protected void onPreExecute() {
        super.onPreExecute();
    }

}