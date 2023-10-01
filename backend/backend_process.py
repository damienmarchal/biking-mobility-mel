import hashlib
import os
import json
import time
import haversine as hs

config_file = "../config.json"
with open(config_file,"r") as f:
    config = json.load(f)

d = os.path.dirname(os.path.abspath(config_file))
path_to_trace_storage = os.path.normpath(os.path. os.path.join(d, config["GENERAL"]["trace-storage"]))
path_to_data_cache = os.path.normpath(os.path.join(d, config["GENERAL"]["data-cache"]))
path_to_backend_state = os.path.normpath(os.path.join(d, config["BACKEND"]["path_to_state"]))

force = config["BACKEND"]["force-refresh"]


print("Data location is: ", path_to_trace_storage)
print("Backend cache location is: ", path_to_data_cache)
print("Backend state location is: ", path_to_backend_state)

if not os.path.exists(path_to_trace_storage):
    print(f"Creating {path_to_trace_storage}")
    os.mkdir(path_to_trace_storage)

if not os.path.exists(path_to_data_cache):
    print(f"Creating {path_to_data_cache}")
    os.mkdir(path_to_data_cache)

if not os.path.exists(path_to_backend_state):
    print(f"Creating {path_to_backend_state}")
    os.mkdir(path_to_backend_state)

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

def generate_status(file_count, trace_count, distance_count):
    print("Generating status for {} files".format(file_count))
    status = {
        "count": file_count,
        "total_size" : int(get_dir_size(path_to_trace_storage)/(1024*1024)),
        "trace_count" : trace_count,
        "total_distance" : distance_count
    }
    json.dump(status, open(os.path.join(path_to_backend_state, "status.json"),"w"))

def get_trace_info(trace_filename):
    hash = md5(trace_filename, {}) 

    cached_name = f"{hash}.json"
    cached_pathname = os.path.join(path_to_data_cache, cached_name)
    if not os.path.exists(cached_pathname) or force:
        print("Trace not in cache... so let's compute")
        logentry = {
            "file" : os.path.basename(trace_filename),
            "date" : time.ctime(os.path.getctime(trace_filename)),
            "trace_count" : get_trace_count(trace_filename),
            "total_distance" : get_trace_distance(trace_filename),
            "md5" : hash
        }
        json.dump(logentry, open(cached_pathname,"w"))    

    return json.load(open(cached_pathname, "r"))

def generate_history():
    files = os.listdir(path_to_trace_storage)
    print("Generating history for {} files".format(len(files)))
    logs = []
    total_distance = 0
    total_trace_count = 0
    for file in files:
        pathfile = os.path.join(path_to_trace_storage, file)
        logentry = get_trace_info(pathfile)
        logs.append(logentry)

        total_trace_count += logentry["trace_count"]
        total_distance += logentry["total_distance"]

    json.dump(logs, open(os.path.join(path_to_backend_state, "history.json"), "w"))
    generate_status(len(files), total_trace_count, total_distance)


generate_history()