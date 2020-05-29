#!/usr/bin/python3
import os, requests, pprint, json, re, sys
import argparse

parser = argparse.ArgumentParser(description='Zenodo Tool')
parser.add_argument('--list', action='store_true', default=False, help='List all depositions and exit')
parser.add_argument('--sandbox', action='store_true', default=False, help='Acto on Zenodo\'s sandbox server instead of real one')
parser.add_argument('--upload', action='store_true', default=False, help='Upload changes')
parser.add_argument('--create', action='store', default=None, help='Create a new deposit using metadata given by the file argument')
parser.add_argument('--deposit', action='store', default=None, help='Deposit a file given by the file argument')
parser.add_argument('--id', action='store', default=None, help='The deposit id to act on')
pres=parser.parse_args(sys.argv[1:])

if "ZENODO_ACCESS" not in os.environ:
    print("You need a zenodo access token to use this tool.")
    sys.exit(1)

access_token = os.environ["ZENODO_ACCESS"]

listdeps = pres.list
sandbox = pres.sandbox
upload = pres.upload
create = pres.create
deposit = pres.deposit
id = pres.id

if upload and not id:
    print("You need to provide an id to upload to.")
    sys.exit(1)

if create and not os.access(create, os.R_OK):
    print("'%s' does not exist or is not readable." % create)
    sys.exit(1)

if create and id != None:
    print("You must not provide an id when creating a new deposit")
    sys.exit(1)

if deposit and not id:
    print("You need to provide an id to deposit to.")
    sys.exit(1)

if deposit and not os.access(deposit, os.R_OK):
    print("'%s' does not exist or is not readable." % deposit)
    sys.exit(1)

if sandbox:
    server = "sandbox.zenodo.org"
else:
    server = "zenodo.org"

if listdeps:
  deps = requests.get("https://{server}/api/deposit/depositions".format(server=server),params={"access_token":access_token})
  assert deps.status_code == 200
  for dep in deps.json():
      print("id:",dep['id'],dep['title'])
  exit(0)

if create:
  c = eval(open(create).read())
  c["submitted"] = False
  dep = requests.post("https://{server}/api/deposit/depositions".format(server=server,id=id),
       data=json.dumps(c),
       headers={"Content-Type": "application/json"},
       params={"access_token":access_token})
  if dep.status_code != 200:
    print("request faild: %s\n%s" % (dep.status_code, dep.json()))
    sys.exit(1)
  c = dep.json()
  id = c["id"]
else:
  dep = requests.get("https://{server}/api/deposit/depositions/{id}".format(server=server,id=id),params={"access_token":access_token})
  c = dep.json()

if deposit:
  # usually the file Definition.md modified like so:
  # sed -i 's/ET_2019_10/ET_2020_05/;s/c32f345352864d88cb4fa6e649262d35da69a1a7/ET_2020_05_v0/g' Definition.md
  bucket_url = c["links"]["bucket"]
  with open(deposit, "rb") as fh:
    dep = requests.post("%s/%s" % (bucket_rul, os.path.basename(deposit)),
         data=fh,
         # No headers included in the request, since it's a raw byte request
         params={"access_token":access_token})
    if dep.status_code != 200:
      print("request faild: %s\n%s" % (dep.status_code, dep.json()))
      sys.exit(1)

creators = {}
with open("developers.txt", "r") as fd:
    for line in fd.readlines():
        cols = line.strip().split(":")
        if cols[0] == "Name":
            continue
        creators[cols[0]] = cols

names = creators.keys()

release_team = [
  "Roland Haas",
  "Brockton Brendal",
  "William E. Gabella",
  "Beyhan Karakaş",
  "Atul Kedia",
  "Shawn G. Rosofsky",
  "Steven R. Brandt",
  "Alois Peter Schaffarczyk",
]

def relkey(name):
    g = re.match(r'^(.+)\s+(\S+)$',name)
    if name in release_team:
        return "A"+g.group(2)+", "+g.group(1)
    else:
        return "Z"+g.group(2)+", "+g.group(1)

for name in release_team:
    assert name in names, name

names = sorted(names,key=relkey)

items = []
for name in names:
    cols = creators[name]
    affiliation = cols[2]
    item = {
        'name':re.sub(r'~',' ',name),
        'affiliation':cols[2]
    }
    if 3 < len(cols) and cols[3].strip() != '':
        orcid = cols[3].strip()
        assert re.match(r'^\d{4}(-[\dX]{4}){3}$',orcid), orcid
        item['orcid'] = orcid
    items += [item]

#c = {'metadata':{'creators':[]}}

c['metadata']['creators'] = items

with open("zupload.py","w") as fd:
    pp = pprint.PrettyPrinter(stream=fd)
    pp.pprint(c)

if upload:
    pp = pprint.PrettyPrinter()
    dep = requests.put("https://{server}/api/deposit/depositions/{id}".format(server=server,id=id),
        data=json.dumps(c),
        headers={"Content-Type": "application/json"},
        params={"access_token":access_token})
    if dep.status_code != 200:
        print("request faild: %s\n%s" % (dep.status_code, dep.json()))
        sys.exit(1)
    pp.pprint(dep.json())
