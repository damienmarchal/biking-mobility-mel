from typing import Union
from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
import os 
import json
import time
import hashlib
import haversine as hs

config_file = "../config.json"
with open(config_file,"r") as f:
    config = json.load(f)

d = os.path.dirname(os.path.abspath(config_file))
path_to_trace_storage = os.path.join(d, config["GENERAL"]["trace-storage"])
path_to_data_cache = os.path.join(d, config["GENERAL"]["data-cache"])

print("Data path is: ", path_to_trace_storage)
print("Backend cache is: ", path_to_data_cache)

def get_dir_size(path='.'):
    total = 0
    with os.scandir(path) as it:
        for entry in it:
            if entry.is_file():
                total += entry.stat().st_size
            elif entry.is_dir():
                total += get_dir_size(entry.path)
    return total

def md5(fname, extra):
    hash_md5 = hashlib.md5(str(extra).encode('utf-8'))
    with open(fname, "rb") as f:
        for chunk in iter(lambda: f.read(4096), b""):
            hash_md5.update(chunk)
    return hash_md5.hexdigest()


def get_trace_distance(trace_filename):



    traces = json.load(open(trace_filename))
    total_distance = 0
    for trace in traces: 
        coordinates = trace["geometry"]["coordinates"]
        trace_distance = 0
        for index in range(len(coordinates)-1):
            loc1 = coordinates[index]
            loc2 = coordinates[index+1]
            loc1 = (loc1[1], loc1[0])
            loc2 = (loc2[1], loc2[0])
            # haversine is returning distance in km and take location using lat,lon  
            trace_distance += hs.haversine(loc1,loc2)
        print("Trace starting at ", trace["start_datetime"], "is", trace_distance)
        total_distance += trace_distance        
    return total_distance
    
def get_trace_count(pathname):
    traces = json.load(open(pathname))
    return len(traces)
    
def get_all_trace_count(path='.'):
    total = 0
    with os.scandir(path) as entries:
        for entry in entries:
            if entry.is_file():
                traces = json.load(open(entry.path))
                total += len(traces)
    return total

origins = [
    "http://127.0.0.1:8000",
    "https://127.0.0.1:8000",
    "http://localhost:8000",
    "https://localhost:8000"
]

app = FastAPI()
app.add_middleware(
    CORSMiddleware,
    allow_origins=origins,
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

@app.get("/status")
def status():
    file = os.listdir(path_to_trace_storage)
    return {
        "count": len(file),
        "total_size" : int(get_dir_size(path_to_trace_storage)/(1024*1024)),
        "trace_count" : get_all_trace_count(path_to_trace_storage),
        "total_distance" : "(calcul en cours)"
    }

@app.get("/submission_history")
def submission_history():
    files = os.listdir(path_to_trace_storage)
    logs = []
    for file in files:
        pathfile = os.path.join(path_to_trace_storage, file)
        logentry = {
            "file" : file,
            "date" : time.ctime(os.path.getctime(pathfile)),
            "trace_count" : get_trace_count(pathfile),
            "total_distance" : get_trace_distance(pathfile),
            "md5" : "4646"
        }
        logs.append(logentry)
    return logs


@app.get("/items/{item_id}")
def read_item(item_id: int, q: Union[str, None] = None):
    return {"item_id": item_id, "q": q}
