package valentecaio.mapquestapp;

import android.util.Log;

import org.json.JSONArray;
import org.json.JSONException;

import java.util.ArrayList;

/**
 * Created by caio on 19/6/2017.
 */

public class DAO {
    // JSON variables and constants
    public String JSON_STRING;
    private static String hostname = "http://s4-projet-50.labs1.web.telecom-bretagne.eu/";

    // query constants
    private static String QUERY_BALADES = "query_read_balades.php";
    private static String QUERY_POINTS = "query_read_points.php";
    private static String QUERY_MEDIAS = "query_read_medias.php";
    private static String QUERY_PARCOURS = "query_read_contenu_parcours.php";

    StrollActivity delegate;
    ArrayList<Balade> balades;
    ArrayList<Point> points;
    ArrayList<Media> medias;
    ArrayList<Parcours> parcours;

    Balade baladeBeingDownloaded;

    private int remainingAcks = 0;

    public DAO(StrollActivity delegate) {
        this.delegate = delegate;
    }

    // read functions
    // the read methods trigger asynchronous tasks (DatabaseQueryAsync),
    // which will send querys to the database and call the method parseQueryResult sending the answer

    public void loadDatabase(){
        new DatabaseQueryAsync(this, hostname, QUERY_POINTS).execute();
        new DatabaseQueryAsync(this, hostname, QUERY_MEDIAS).execute();
        new DatabaseQueryAsync(this, hostname, QUERY_BALADES).execute();
        new DatabaseQueryAsync(this, hostname, QUERY_PARCOURS).execute();
    }

    // steps to download balade:
    // 0) request all points and medias, and the lookup table parcours => the constructor does it
    // 1) request all points from this balade
    // 2) request all medias from each point
    // 3) download medias
    // 4) write data in internal database
    public void downloadBalade(Balade b){
        // step 1
        ArrayList<Point> points_in_balade = pointsInBalade(b);
        b.setPoints(points_in_balade);

        // step 2
        ArrayList<String> medias_in_balade = mediasInBalade(b);

        // step 3
        for(String media_name: medias_in_balade){
            Log.i("DOWNLOAD_BALADE", "media " + media_name);
            downloadMedia(media_name);
        }

        // step 4 is triggered by onFinishMediaDownload
        this.baladeBeingDownloaded = b;
    }

    // return all points of a Balade, searching in the global array points
    private ArrayList<Point> pointsInBalade(Balade b){
        // find IDs in balade
        ArrayList<Integer> point_ids_in_balade = new ArrayList<>();
        for(Parcours parc: this.parcours){
            if(parc.getId_balade() == b.getId()){
                point_ids_in_balade.add(parc.getId_point());
            }
        }

        // find points with matching IDs
        ArrayList<Point> points_in_balade = new ArrayList<>();
        for(int id: point_ids_in_balade) {
            for (Point p : this.points) {
                if (p.getId() == id) {
                    points_in_balade.add(p);
                }
            }
        }
        return points_in_balade;
    }

    // return all medias of a Balade, searching in the global array medias
    private ArrayList<String> mediasInBalade(Balade b){
        ArrayList<String> medias_of_balade = new ArrayList<>();

        for(Point p: b.getPoints()){
            ArrayList<String> medias_of_point = new ArrayList<>();
            for(Media m: this.medias){
                if(m.getPoint_id() == p.getId()){
                    medias_of_point.add(m.getFilename());
                }
            }
            p.setMedias(medias_of_point);
            medias_of_balade.addAll(medias_of_point);
        }

        return medias_of_balade;
    }

    private void downloadMedia(String media_name){
        // trigger download async task
        new DownloadMediasAsync(this, hostname, media_name).execute();
        // wait for acknowledgement
        remainingAcks++;

        Log.i("DOWNLOAD_MEDIA", "waiting ack for file " + media_name + ", remaining acks: " + remainingAcks);
    }

    // may be called by the DownloadMediasAsync when the download is finished
    public void onFinishMediaDownload(String filename){
        // count received acknowledgement
        remainingAcks--;

        // if it was the last acknowledgement, do step 4 of download balade
        if(remainingAcks == 0) {
            // step 4: write balade and points informations
            AppFileManager afm = new AppFileManager(this.delegate.getApplicationContext());
            afm.writeBaladeAndPoints(baladeBeingDownloaded);

            // when finishing task enable download buttons again
            // sendSignalBaladeDownloaded
            delegate.signalBaladeDownloadFinished(baladeBeingDownloaded);
        }

        Log.i("DOWNLOAD_MEDIA", "receivec ack for file " + filename + ", remaining acks: " + remainingAcks);
    }

    // may be called by the DatabaseQueryAsync when the query result is received from database
    public void parseQueryResult(String result, String query){
        // avoid errors when receiving null results
        result = result==null ? "" : result;
        Log.i("query_result", result);

        try {
            if(query == QUERY_POINTS){
                this.points = new ArrayList<>();
                JSONArray array = new JSONArray(result);
                for(int i=0; i<array.length(); i++){
                    int id = array.getJSONObject(i).getInt("id");
                    String name = array.getJSONObject(i).getString("name");
                    Double lon = array.getJSONObject(i).getDouble("lon");
                    Double lat = array.getJSONObject(i).getDouble("lat");
                    String descript = array.getJSONObject(i).getString("txt");
                    points.add(new Point(id, lat, lon, name, descript));
                }
            } else if (query == QUERY_BALADES){
                ArrayList<Balade> balades = new ArrayList<>();
                JSONArray array = new JSONArray(result);
                for(int i=0; i<array.length(); i++){
                    int id = array.getJSONObject(i).getInt("id");
                    String name = array.getJSONObject(i).getString("name");
                    String theme = array.getJSONObject(i).getString("theme");
                    String descript = array.getJSONObject(i).getString("description");
                    balades.add(new Balade(id, name, theme, descript));
                }
                this.setBalades(balades);
            } else if (query == QUERY_MEDIAS){
                this.medias = new ArrayList<>();
                JSONArray array = new JSONArray(result);
                for(int i=0; i<array.length(); i++){
                    int id = array.getJSONObject(i).getInt("id_media");
                    int id_point = array.getJSONObject(i).getInt("id_point_ref");
                    String filename = array.getJSONObject(i).getString("filepath");
                    medias.add(new Media(id, id_point, filename));
                }
            }else if (query == QUERY_PARCOURS){
                this.parcours = new ArrayList<>();
                JSONArray array = new JSONArray(result);
                for(int i=0; i<array.length(); i++){
                    int id_balade = array.getJSONObject(i).getInt("id_b");
                    int id_point = array.getJSONObject(i).getInt("id_p");
                    parcours.add(new Parcours(id_point, id_balade));
                }
            }
            enableButtonsInDelegate(true);
        } catch (JSONException e) {
            e.printStackTrace();
        }
    }

    private void setBalades(ArrayList<Balade> balades) {
        this.balades = balades;
        delegate.setBaladesArray(balades);
    }

    private void enableButtonsInDelegate(boolean state){
        state = state && (this.points!=null && this.balades!=null
                && this.medias!=null && this.parcours!=null);
        delegate.enableButtons(state);
    }
}
