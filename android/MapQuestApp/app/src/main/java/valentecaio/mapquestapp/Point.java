package valentecaio.mapquestapp;

import com.mapbox.mapboxsdk.geometry.LatLng;

import java.util.ArrayList;

/**
 * Created by caio on 07/05/2017.
 */

public class Point {
    private String id;
    private double latitude;
    private double longitude;
    private String name;
    private String description;
    private ArrayList medias = new ArrayList();

    public Point(String name, double latitude, double longitude) {
        this.name = name;
        this.latitude = latitude;
        this.longitude = longitude;
    }

    public Point(String id, double latitude, double longitude, String name, String description) {
        this.id = id;
        this.latitude = latitude;
        this.longitude = longitude;
        this.name = name;
        this.description = description;
    }

    public String getId() {
        return id;
    }

    public ArrayList getMedias() {
        return medias;
    }

    public void addMedia(String path) {
        this.medias.add(path);
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public double getLatitude() {
        return latitude;
    }

    public void setLatitude(double latitude) {
        this.latitude = latitude;
    }

    public double getLongitude() {
        return longitude;
    }

    public void setLongitude(double longitude) {
        this.longitude = longitude;
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

    public void setMedias(ArrayList medias) {
        this.medias = medias;
    }

    @Override
    public String toString(){
        return "Point " + getName() + " [" + getLongitude() + ", " + getLatitude() + "]";
    }
}