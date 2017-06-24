package valentecaio.mapquestapp;

/**
 * Created by caio on 24/6/2017.
 */

public class Parcours {
    private int id_point;
    private int id_balade;

    public Parcours(int id_point, int id_balade) {
        this.id_point = id_point;
        this.id_balade = id_balade;
    }

    public int getId_point() {
        return id_point;
    }

    public int getId_balade() {
        return id_balade;
    }
}
