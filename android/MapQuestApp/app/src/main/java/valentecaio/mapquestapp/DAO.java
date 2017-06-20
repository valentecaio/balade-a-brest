package valentecaio.mapquestapp;

import java.util.ArrayList;

/**
 * Created by caio on 19/6/2017.
 */

public class DAO {
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
    public static ArrayList<Balade> fake_readAllBalades(){
        ArrayList<Balade> list = new ArrayList<Balade>();
        for(int id=0; id<10; id++){
            Balade b = new Balade(String.valueOf(id), "balade " + id, "Medieval");
            list.add(b);
        }
        return list;
    }
}
