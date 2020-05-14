#!/usr/bin/python3
import re

headers = None
missing = {}
devs = {}
with open("developers.txt","r") as fd:
    for line in fd.readlines():
        # skip comments
        if line.lstrip().startswith("#"):
             continue
        # skip empty lines
        if line.lstrip() == "":
            continue

        cols = line.strip().split(":")

        entry = [re.sub(r'~',' ',cols[0])]
        if 2 < len(cols):
            entry += [cols[2]]
        if 3 < len(cols):
            entry += [cols[3]]
        while 3 > len(entry):
            entry += ["&nbsp;"]
        if cols[0] in devs:
            raise Exception("Duplicate:",cols[0])
        devs[cols[0]] = entry

        if headers == None:
            headers = cols
        else:
            if len(cols) > len(headers):
                raise Exception("Too many columns:",cols)
            if len(cols) == 4:
                if re.match(r'^\s*$',cols[3]) or re.match(r'\s*\w{4}(-\w{4}){3}\s*$',cols[3]):
                    pass
                else:
                    raise Exception("Bad ORCID:",cols)
            for i in range(1,len(headers)):
                if i >= len(cols) or re.match(r'^\s*$',cols[i]):
                    h = headers[i]
                    if h not in missing:
                        missing[h] = 0
                    print("Missing %s for user %s" % (headers[i], cols[0]))
                    missing[h] += 1

def dist(a,b):
    d = (len(a)+len(b))/2
    h = {}
    for c in a:
        if c not in h:
            h[c]=0
        h[c] += 1
    for c in b:
        if c not in h:
            h[c]=0
        h[c] -= 1
    sum = 0
    for v in h.values():
        sum += abs(v)
    return sum/d

devlist = [k for k in devs.keys()]
for i in range(len(devlist)):
    for j in range(i+1,len(devlist)):
        d = dist(devlist[i],devlist[j])
        if d < .3:
            print("Possible dup:",devlist[i],"and",devlist[j])

print("Items missing:",missing)

def namekey(name):
    g = re.match(r'^\s*([\w\'-]+)\s*(.*)',name)
    return g.group(2)+", "+g.group(1)
with open('developers.html','w') as fd:
    print("""
<!DOCTYPE html>
<html lang="en">
<head>
  <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="head.js" type="text/javascript">
  </script>
  <title>Developers of the ETK</title>
</head>
<body id="developers">
    <h1>Developers of the ETK</h1>""",file=fd)
    print("<table cellpadding=5 cellspacing=0 border=1>",file=fd)
    devlist = sorted(devs.keys(),key=namekey)
    for dev in devlist:
        print("<tr><td>",end='',file=fd)
        print("</td><td>".join(devs[dev]),end='',file=fd)
        print("</td></tr>",file=fd)
    print("</table>",file=fd)
    print("""
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <script src="footer/footer.js" type="text/javascript">
        </script>
      </div>
    </div>
  </div>
</body>
</html>""",file=fd)
