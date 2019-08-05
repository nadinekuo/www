#!/usr/bin/python3
import re

headers = None
missing = {}
with open("developers.txt","r") as fd:
    for line in fd.readlines():
        cols = line.strip().split(":")
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
