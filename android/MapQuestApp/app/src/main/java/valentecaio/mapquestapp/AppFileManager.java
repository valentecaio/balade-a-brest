package valentecaio.mapquestapp;

import android.content.Context;
import android.util.Log;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.util.ArrayList;

/**
 * Created by caio on 18/06/2017.
 */

public class AppFileManager {
    private String name;
    private FileOutputStream outputStream;
    private Context context;

    private static String fileType = ".csv";
    private static String separator = "===";
    private static String point_prefix = "point_";
    private static String balade_prefix = "balade_";

    public AppFileManager(Context context) {
        this.context = context.getApplicationContext();
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    private String nameWithType() {
        String str = this.name;
        if (!this.name.contains(this.fileType)) {
            str += this.fileType;
        }
        return str;
    }

    private void write(String data) {
        try {
            String nameToWrite = nameWithType();

            OutputStreamWriter outputStreamWriter = new OutputStreamWriter(
                    context.openFileOutput(nameToWrite, Context.MODE_PRIVATE));
            outputStreamWriter.write(data);
            outputStreamWriter.close();
            IO.print(this, "wrote with sucess the file " + nameToWrite);
        } catch (IOException e) {
            Log.e("Exception", "File write failed: " + e.toString());
        }
    }

    private boolean formatIsCSV(File file) {
        return file.getName().contains(fileType);
    }

    public String read() {
        String ret = "";
        try {
            String nameToRead = nameWithType();
            InputStream inputStream = context.openFileInput(nameToRead);
            IO.print("reading from " + nameToRead);

            if (inputStream != null) {
                InputStreamReader inputStreamReader = new InputStreamReader(inputStream);
                BufferedReader bufferedReader = new BufferedReader(inputStreamReader);
                String receiveString = "";
                StringBuilder stringBuilder = new StringBuilder();

                while ((receiveString = bufferedReader.readLine()) != null) {
                    stringBuilder.append(receiveString);
                }

                inputStream.close();
                ret = stringBuilder.toString();
            }
        } catch (FileNotFoundException e) {
            Log.e("login activity", "File not found: " + e.toString());
        } catch (IOException e) {
            Log.e("login activity", "Can not read file: " + e.toString());
        }

        return ret;
    }

    public Point readPoint(String id){
        // read csv file
        this.setName(point_prefix + id + fileType);
        String csv = read();

        // split read data
        String[] data = csv.split(separator);
        String id_str = data[0];
        String name = data[1];
        String description = data[2];
        Double longitude = new Double(data[3]);
        Double latitude = new Double(data[4]);

        // transform string data in Point object
        Point p = new Point(id_str, longitude, latitude, name, description);
        for(int i=5; i<data.length; i++){
            p.addMedia(data[i]);
        }
        return p;
    }

    public Balade readBalade(String id){
        // read csv file
        this.setName(balade_prefix + id + fileType);
        String csv = read();

        // split read data
        String[] data = csv.split(separator);
        String id_str = data[0];
        String name = data[1];
        String theme = data[2];

        // transform string data in Balade object
        Balade b = new Balade(id_str, name, theme);
        for(int i=3; i<data.length; i++){
            b.addPoint(data[i]);
        }
        return b;
    }

    public void writePoint(Point p){
        String s = p.getId()
                + separator + p.getName()
                + separator + p.getDescription()
                + separator + p.getLongitude()
                + separator + p.getLatitude();
        ArrayList medias = p.getMedias();
        for(Object m: medias){
            s +=  separator + m.toString();
        }

        this.setName(point_prefix + p.getId() + fileType);
        write(s);
    }

    public void writeBalade(Balade b){
        String s = b.getId()
                + separator + b.getName()
                + separator + b.getTheme();
        ArrayList points = b.getPoints();
        for(Object o: points){
            s +=  separator + ((Point)o).getId();
        }

        this.setName(balade_prefix + b.getId() + fileType);
        write(s);
    }

    private File[] getFiles(){
        String path = this.context.getFilesDir().getAbsolutePath();
        IO.print("Path: " + path);
        File directory = new File(path);
        File[] files = directory.listFiles();
        return files;
    }

    public ArrayList<String> readAll() {
        File[] files = this.getFiles();

        // read files
        ArrayList<String> results = new ArrayList<String>();
        for (File file : files) {
            if (formatIsCSV(file)) {
                this.name = (file.getName());
                results.add(read());
            }
        }
        return results;
    }

    public boolean deleteAll() {
        File[] files = this.getFiles();

        boolean deleted = true;
        for (File file : files) {
            if (formatIsCSV(file)) {
                IO.print("deleting " + file.getName());
                deleted = file.delete() && deleted;
            }
        }
        return deleted;
    }

    public boolean deleteFile() {
        File[] files = this.getFiles();

        boolean deleted = true;
        for (File file : files) {
            String nameToDelete = nameWithType();
            if (nameToDelete.equals(file.getName()) && formatIsCSV(file)) {
                IO.print("deleting " + file.getName());
                deleted = file.delete();
            }
        }
        return deleted;
    }
}