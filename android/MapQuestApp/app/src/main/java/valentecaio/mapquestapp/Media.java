package valentecaio.mapquestapp;

/**
 * Created by caio on 24/6/2017.
 */

public class Media {
    private String media_id;
    private String point_id;
    private String filename;

    public Media(String media_id, String point_id, String filename) {
        this.media_id = media_id;
        this.point_id = point_id;
        this.filename = filename;
    }

    public String getMedia_id() {
        return media_id;
    }

    public String getPoint_id() {
        return point_id;
    }

    public String getFilename() {
        return filename;
    }
}
