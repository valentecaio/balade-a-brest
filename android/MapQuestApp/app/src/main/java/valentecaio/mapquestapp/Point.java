package valentecaio.mapquestapp;

import com.mapbox.mapboxsdk.geometry.LatLng;

import java.util.ArrayList;

/**
 * Created by caio on 07/05/2017.
 */

public class Point {
    private int id;
    private double latitude;
    private double longitude;
    private String name;
    private String description;
    private ArrayList<String> medias = new ArrayList();

    public Point(int id, double latitude, double longitude, String name, String description) {
        this.id = id;
        this.latitude = latitude;
        this.longitude = longitude;
        this.name = name;
        this.setDescription(description);
    }

    public int getId() {
        return id;
    }

    public ArrayList<String> getMedias() {
        return medias;
    }

    public void addMedia(String path) {
        this.medias.add(path);
    }

    public String getDescription() {
        return description!=null ? description : "";
    }

    public void setDescription(String description) {
        this.description = description.equals("null") ? null : description;
    }

    public double getLatitude() {
        return latitude;
    }

    public double getLongitude() {
        return longitude;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public LatLng getLocation() {
        return new LatLng(getLatitude(), getLongitude());
    }

    public void setMedias(ArrayList<String> medias) {
        this.medias = medias;
    }

    @Override
    public String toString(){
        return "Point " + getName() + " [" + getLongitude() + ", " + getLatitude() + "]";
    }
}