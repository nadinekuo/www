#!/usr/bin/env python3

# Generate the code to include in tutorial-whitelist.txt
# The CILogon identifier (the email address) is provided
# to this program on the command line, and the resulting
# code is added to the whitelist.
import hashlib, base64, re, sys

def codeme(m):
    t = type(m)
    if t == str:
        m = m.encode()
    elif t == bytes:
        pass
    else:
        raise Exception(str(t))
    h = hashlib.md5(m)
    v = base64.b64encode(h.digest())
    s = re.sub(r'[\+/]','_', v.decode())
    return s[:-2]

codes = set()
file_name = "tutorials-whitelist.txt"
with open(file_name, "r") as fd:
    for line in fd.readlines():
        code = line.strip()
        codes.add(code)

for name in sys.argv[1:]:
    code = codeme(name)
    print(name, "->", code)
    if code not in codes:
        codes.add(code)
    else:
        print("code is already in list")
        exit(0)

with open(file_name, "w") as fd:
    for code in sorted(codes):
        print(code, file=fd)
