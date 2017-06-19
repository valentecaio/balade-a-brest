package valentecaio.mapquestapp;

import java.util.ArrayList;

/**
 * Created by caio on 19/6/2017.
 */

public class DAO {
    // return a balade with all information (points and medias)
    public static Balade fake_downloadBalade(String id){
        return new Balade(id, "balade " + id, "Medieval");
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
