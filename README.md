Toolbox to process gps/gpx data from biking challenge. 

The boox is composed of two components:
- a public website front-end to collect gps/gpx data. This website is implemented in php. 
- a backend REST api to present the results. The backend is implemented in python. 

Deployement
-----------
Add a config.ini so that the frontend knows:
- the directory where the uploaded data will be stored
- the directory where the uploaded data will be copied for processing by the backend 
- the main http address of the backend rest API
