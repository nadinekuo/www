#!/usr/bin/python3
import re

headers = None
missing = 0
with open("developers.txt","r") as fd:
    for line in fd.readlines():
        cols = line.strip().split(":")
        if headers == None:
            headers = cols
        else:
            if len(cols) > len(headers):
                raise Exception("Too many columns:",cols)
            if len(cols) == 4:
                if not re.match(r'\s*\d{4}(-\d{4}){3}\s*$',cols[3]):
                    raise Exception("Bad ORCID:",cols)
            for i in range(1,len(headers)):
                if i >= len(cols):
                    print("Missing %s for user %s" % (headers[i], cols[0]))
                    missing += 1
print("Items missing:",missing)
