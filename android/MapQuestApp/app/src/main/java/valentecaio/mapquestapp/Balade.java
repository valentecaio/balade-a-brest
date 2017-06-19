package valentecaio.mapquestapp;

import java.util.ArrayList;

/**
 * Created by caio on 18/6/2017.
 */

public class Balade {
    private String id;
    private String name;
    private String theme;
    private ArrayList<Point> points = new ArrayList<Point>();

    public Balade(String id, String name, String theme) {
        this.id = id;
        this.name = name;
        this.theme = theme;
    }

    public Balade(String name, String theme) {
        this.name = name;
        this.theme = theme;
    }

    public ArrayList<Point> getPoints() {
        return points;
    }

    public void addPoint(Point p) {
        this.points.add(p);
    }

    public void addPoint(String id) {
        // TODO: this function may find the point using its id and add the Point to this.points
        // Point p = fundById(id);
        // addPoint(p);
    }

    public String getId() {
        return id;
    }

    public String getName() {
        return name;
    }

    public String getTheme() {
        return theme;
    }

    @Override
    public String toString() {
        return getName() + " (" + getPoints().size() + " points)";
    }
}
