from typing import Union
from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
import os 
import json
import time
import hashlib

config_file = "../config.json"
with open(config_file,"r") as f:
    config = json.load(f)

d = os.path.dirname(os.path.abspath(config_file))
path_to_trace_storage = os.path.normpath(os.path. os.path.join(d, config["GENERAL"]["trace-storage"]))
path_to_data_cache = os.path.normpath(os.path.join(d, config["GENERAL"]["data-cache"]))
path_to_backend_state = os.path.normpath(os.path.join(d, config["BACKEND"]["path_to_state"]))

print("Data path location is: ", path_to_trace_storage)
print("Backend cache location is: ", path_to_data_cache)
print("Backend state location is: ", path_to_backend_state)

origins = config["BACKEND"]["allow-origins"]

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
    return json.load(open(os.path.join(path_to_backend_state ,"status.json"))) 

@app.get("/submission_history")
def submission_history():
    return json.load(open(os.path.join(path_to_backend_state, "history.json"))) 