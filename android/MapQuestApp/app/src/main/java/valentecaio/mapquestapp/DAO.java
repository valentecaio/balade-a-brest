package valentecaio.mapquestapp;

import android.os.AsyncTask;
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
    private static String QUERY_MEDIAS = "";

    StrollActivity delegate;

    public DAO(StrollActivity delegate) {
        this.delegate = delegate;
    }

    // return a balade with all information (points and medias)
    public static Balade fake_downloadBalade(String id){
        Balade b = new Balade(id, "balade " + id, "Medieval");

        Point tour = new Point("1", 48.383421, -4.497139, "tour", "description");
        Point jardin = new Point("2", 48.381615, -4.499135, "jardin", "description");
        Point tram = new Point("3", 48.384105, -4.499425, "tram", "description");
        Point laverie = new Point("4", 48.357061, -4.570031, "laverie", "description");
        Point cv = new Point("5", 48.358906, -4.570013, "centre vie", "description");
        Point imt_statue = new Point("6", 48.360124, -4.570747, "imt statue", "description");
        Point cv4 = new Point("7", 48.358974, -4.569635, "departement des langues", "description");
        Point cv5 = new Point("8", 48.358899, -4.570263, "departement informatique", "description");
        Point cv6 = new Point("9", 48.358823, -4.570081, "salle meridianne", "description");

        Point[] array = new Point[] { cv, tram, laverie, tour, imt_statue, cv4, jardin, cv5, cv6 };
        for(Point p: array){
            b.addPoint(p);
        }

        return b;
    }

    // return an array of balades without any point or medias attached
    public static ArrayList<Balade> fake_readAllBalades() {
        ArrayList<Balade> list = new ArrayList<Balade>();
        for (int id = 0; id < 10; id++) {
            Balade b = new Balade(String.valueOf(id), "balade " + id, "Medieval");
            list.add(b);
        }
        return list;
    }


    // read functions
    // the read methods trigger asynchronous tasks (DatabaseQueryAsync),
    // which will send querys to the database and call the method parseQueryResult sending the answer

    public void readAllBalades(){
        new DatabaseQueryAsync(this, hostname, QUERY_BALADES).execute();
    }

    public void readAllPoints(){
        new DatabaseQueryAsync(this, hostname, QUERY_POINTS).execute();
    }

    public void downloadBalade(){
        // 1) request all points from this balade
        // 2) request all medias from each point
        // 3) make a queue with all these medias
        // 4) start to download medias

        // download a media as example:
        new DownloadMediasAsync(this, hostname, "mtb.mp4").execute();
        new DownloadMediasAsync(this, hostname, "danilo.png").execute();
    }

    // may be called by the DatabaseQueryAsync when the query result is received from database
    public void parseQueryResult(String result, String query){
        Log.i("query_result", result);
        try {
            if(query == QUERY_POINTS){
                ArrayList<Point> points = new ArrayList<>();
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
                delegate.setBaladesArray(balades);
            } else if (query == QUERY_MEDIAS){

            }
        } catch (JSONException e) {
            e.printStackTrace();
        }
    }
}
