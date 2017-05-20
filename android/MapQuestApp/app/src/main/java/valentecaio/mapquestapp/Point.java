package valentecaio.mapquestapp;

import com.mapbox.mapboxsdk.geometry.LatLng;

/**
 * Created by caio on 07/05/2017.
 */

public class Point {
    private double latitude;
    private double longitude;
    private String name;

    public Point(String name, double latitude, double longitude) {
        this.name = name;
        this.latitude = latitude;
        this.longitude = longitude;
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

    @Override
    public boolean equals(Object obj) {
        if (obj == null) {
            return false;
        }

        if (!Point.class.isAssignableFrom(obj.getClass())) {
            return false;
        }
        final Point other = (Point) obj;

        if ((this.getName() == null) ? (other.getName() != null) : !this.name.equals(other.name)) {
            return false;
        }
        return true;
    }

    @Override
    public String toString(){
        return "Point " + getName() + " [" + getLongitude() + ", " + getLatitude() + "]";
    }
}