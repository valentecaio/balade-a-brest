package valentecaio.mapquestapp;

/**
 * Created by caio on 24/6/2017.
 */

public class Parcours {
    private String id_point;
    private String id_balade;

    public Parcours(String id_point, String id_balade) {
        this.id_point = id_point;
        this.id_balade = id_balade;
    }

    public String getId_point() {
        return id_point;
    }

    public String getId_balade() {
        return id_balade;
    }
}
