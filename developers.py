#!/usr/bin/python3
import re

headers = None
missing = {}
devs = {}
with open("developers.txt","r") as fd:
    for line in fd.readlines():
        cols = line.strip().split(":")

        entry = [cols[0]]
        if 2 < len(cols):
            entry += [cols[2]]
        if 3 < len(cols):
            entry += [cols[3]]
        while 3 > len(entry):
            entry += ["&nbsp;"]
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
print("Items missing:",missing)

def namekey(name):
    g = re.match(r'^\s*(\w+)\s*(.*)',name)
    return g.group(2)+", "+g.group(1)
with open('developers.html','w') as fd:
    print("<table cellpadding=5 cellspacing=0 border=1>",file=fd)
    devlist = sorted(devs.keys(),key=namekey)
    for dev in devlist:
        print("<tr><td>",end='',file=fd)
        print("</td><td>".join(devs[dev]),end='',file=fd)
        print("</td></tr>",file=fd)
    print("</table>",file=fd)
