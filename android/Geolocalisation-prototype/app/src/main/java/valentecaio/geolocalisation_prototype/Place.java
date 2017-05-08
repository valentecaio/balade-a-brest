package valentecaio.geolocalisation_prototype;

/**
 * Created by caio on 03/04/2017.
 */

public class Place {
    private double longitude;
    private double latitude;
    private String name;

    public Place(double longitude, double latitude, String name) {
        this.longitude = longitude;
        this.latitude = latitude;
        this.name = name;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
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

    @Override
    public String toString() {
        return this.name + "[" + this.longitude + " , " + this.latitude + "]";
    }

    @Override
    public boolean equals(Object obj) {
        try {
            Place p = (Place) obj;
            return (this.latitude == p.latitude) &&
                    (this.longitude == p.longitude);
        } catch(Exception ex) {
            return false;
        }
    }
}
