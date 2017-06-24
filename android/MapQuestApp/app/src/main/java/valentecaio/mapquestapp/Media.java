package valentecaio.mapquestapp;

/**
 * Created by caio on 24/6/2017.
 */

public class Media {
    private int media_id;
    private int point_id;
    private String filename;

    public Media(int media_id, int point_id, String filename) {
        this.media_id = media_id;
        this.point_id = point_id;
        this.filename = filename;
    }

    public int getMedia_id() {
        return media_id;
    }

    public int getPoint_id() {
        return point_id;
    }

    public String getFilename() {
        return filename;
    }

    @Override
    public String toString() {
        return this.getFilename();
    }
}
