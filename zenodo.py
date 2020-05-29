#!/usr/bin/python3
import os, requests, pprint, json, re, sys
import argparse

parser = argparse.ArgumentParser(description='Zenodo Tool')
parser.add_argument('--list', action='store_true', default=False, help='List all depositions and exit')
parser.add_argument('--sandbox', action='store_true', default=False, help='Acto on Zenodo\'s sandbox server instead of real one')
parser.add_argument('--upload', action='store_true', default=False, help='Upload changes')
parser.add_argument('--create', action='store', default=None, help='Create a new deposit using metadata given by the file argument')
parser.add_argument('--newversion', action='store_true', default=None, help='Create a new version for the deposit')
parser.add_argument('--deposit', action='store', default=None, help='Deposit a file given by the file argument')
parser.add_argument('--publish', action='store_true', default=False, help='Publish changes (cannot be reverted)')
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
newversion = pres.newversion
deposit = pres.deposit
publish = pres.publish
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

if newversion and not id:
    print("You need to provide an id to create a new version for.")
    sys.exit(1)

if create and newversion:
   # TODO: allow this by checking for id being set only if not create
   print("Only one of --create or --newversion is allowed")
   sys.exit(1)

if deposit and not id:
    print("You need to provide an id to deposit to.")
    sys.exit(1)

if deposit and not os.access(deposit, os.R_OK):
    print("'%s' does not exist or is not readable." % deposit)
    sys.exit(1)

if publish and not id:
    print("You need to provide an id to publish.")
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
  dep = requests.post("https://{server}/api/deposit/depositions".format(server=server),
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
  if dep.status_code != 200:
    print("request faild: %s\n%s" % (dep.status_code, dep.json()))
    sys.exit(1)
  c = dep.json()

if newversion:
  dep = requests.post("https://{server}/api/deposit/depositions/{id}/actions/newversion".format(server=server,id=id),
       params={"access_token":access_token})
  if dep.status_code != 200:
    print("request faild: %s\n%s" % (dep.status_code, dep.json()))
    sys.exit(1)
  c = dep.json()
  # the docs (https://developers.zenodo.org/#new-version) say:
  # > The response body of this action is NOT the new version deposit, but the
  # > original resource. The new version deposition can be accessed through the
  # > "latest_draft" under "links" in the response body. - The id used to create
  # > this new version has to be the id of the latest version. It is not possible
  # > to use the global id that references all the versions.
  # so get that id and data
  dep = requests.get(c["links"]["latest_draft"],params={"access_token":access_token})
  if dep.status_code != 200:
    print("request faild: %s\n%s" % (dep.status_code, dep.json()))
    sys.exit(1)
  c = dep.json()
  id = c["id"]

if deposit:
  # usually the file Definition.md modified like so:
  # sed -i 's/ET_2019_10/ET_2020_05/;s/c32f345352864d88cb4fa6e649262d35da69a1a7/ET_2020_05_v0/g' Definition.md
  bucket_url = c["links"]["bucket"]
  with open(deposit, "rb") as fh:
    dep = requests.put("%s/%s" % (bucket_url, os.path.basename(deposit)),
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

et_release = "ET_2020_05"
et_release_codename = "Turing"

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
c['metadata']['version'] = 'The "{et_release_codename}" release, {et_release}'.format(et_release=et_release, et_release_codename=et_release_codename)

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

if publish:
    answer = input('Really publish (cannot be reverted)? Have you double checked upload.py and have someone look at a dummy commit in the Zenodo sandbox? (yes/no) ')
    if answer != "yes":
        print("Aborting publishing")
        sys.exit(0)
    dep = requests.post("https://{server}/api/deposit/depositions/{id}/actions/publish".format(server=server,id=id),
        params={"access_token":access_token})
    if dep.status_code != 200:
        print("request faild: %s\n%s" % (dep.status_code, dep.json()))
        sys.exit(1)
