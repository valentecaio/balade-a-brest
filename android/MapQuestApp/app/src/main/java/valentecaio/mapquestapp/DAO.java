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

    public DAO(StrollActivity delegate) {
        this.delegate = delegate;
        this.loadDatabase();
    }

    // read functions
    // the read methods trigger asynchronous tasks (DatabaseQueryAsync),
    // which will send querys to the database and call the method parseQueryResult sending the answer

    private void loadDatabase(){
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
        ArrayList<Media> medias_in_balade = mediasInBalade(b);

        // step 3
        for(Media m: medias_in_balade){
            Log.i("DOWNLOAD_BALADE", "media " + m.getFilename());
            new DownloadMediasAsync(this, hostname, m.getFilename()).execute();
        }

        // step 4
        AppFileManager afm = new AppFileManager(this.delegate.getApplicationContext());
        afm.writeBaladeAndPoints(b);
    }

    // return all points of a Balade, searching in the global array points
    private ArrayList<Point> pointsInBalade(Balade b){
        // find IDs in balade
        ArrayList<String> point_ids_in_balade = new ArrayList<>();
        for(Parcours parc: this.parcours){
            if(parc.getId_balade().equals(b.getId())){
                point_ids_in_balade.add(parc.getId_point());
            }
        }

        // find points with matching IDs
        ArrayList<Point> points_in_balade = new ArrayList<>();
        for(String id: point_ids_in_balade) {
            for (Point p : this.points) {
                if (p.getId().equals(id)) {
                    points_in_balade.add(p);
                }
            }
        }
        return points_in_balade;
    }

    // return all medias of a Balade, searching in the global array medias
    private ArrayList<Media> mediasInBalade(Balade b){
        ArrayList<Media> medias_of_balade = new ArrayList<>();

        for(Point p: b.getPoints()){
            ArrayList<Media> medias_of_point = new ArrayList<>();
            for(Media m: this.medias){
                if(m.getPoint_id().equals(p.getId())){
                    medias_of_point.add(m);
                }
            }
            p.setMedias(medias_of_point);
            medias_of_balade.addAll(medias_of_point);
        }

        return medias_of_balade;
    }

    // may be called by the DatabaseQueryAsync when the query result is received from database
    public void parseQueryResult(String result, String query){
        Log.i("query_result", result);
        try {
            if(query == QUERY_POINTS){
                this.points = new ArrayList<>();
                JSONArray array = new JSONArray(result);
                for(int i=0; i<array.length(); i++){
                    String id = array.getJSONObject(i).getString("id");
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
                    String id = array.getJSONObject(i).getString("id");
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
                    String id = array.getJSONObject(i).getString("id_media");
                    String id_point = array.getJSONObject(i).getString("id_point_ref");
                    String filename = array.getJSONObject(i).getString("filepath");
                    medias.add(new Media(id, id_point, filename));
                }
            }else if (query == QUERY_PARCOURS){
                this.parcours = new ArrayList<>();
                JSONArray array = new JSONArray(result);
                for(int i=0; i<array.length(); i++){
                    String id_balade = array.getJSONObject(i).getString("id_b");
                    String id_point = array.getJSONObject(i).getString("id_p");
                    parcours.add(new Parcours(id_point, id_balade));
                }
            }
            enableButtonsInDelegate();
        } catch (JSONException e) {
            e.printStackTrace();
        }
    }

    private void setBalades(ArrayList<Balade> balades) {
        this.balades = balades;
        delegate.setBaladesArray(balades);
    }

    private void enableButtonsInDelegate(){
        if(this.points!=null && this.balades!=null &&
                this.medias!=null && this.parcours!=null){
            delegate.enableButtons(true);
        }
    }
}
