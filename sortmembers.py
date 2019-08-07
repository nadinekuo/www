#!/usr/bin/python3
import re, os
members = {}
with open("members.txt","r") as fd:
    for line in fd.readlines():
        g = re.match('^\S.*\S',line)
        if g:
            key = g.group(0)
            if key not in members:
                members[key] = {}
        else:
            g = re.match('^ \S.*\S',line)
            if g:
                members[key][g.group(0)] = 1

def memkey(k):
    if k == 'Individuals without affiliation':
        return k
    g = re.match('https?:\S+\s+(?:The\s+|)(\S.*\S)',k)
    if not g:
        raise Exception('Bad key:'+k)
    return g.group(1)

def pkey(k):
    k = re.sub(r'https?:\S+\s+','',k)
    g = re.match(r'(.*)\b(\w.*)',k)
    return g.group(2)+' '+g.group(1)

univ = sorted(members.keys(), key=memkey)
with open(".members.txt","w") as fd:
    for k in univ:
        people = sorted(members[k].keys(),key=pkey)
        print(k,file=fd)
        for p in people:
            print(p,file=fd)
        print('',file=fd)

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

os.remove("members.txt")
os.rename(".members.txt","members.txt")

header = False
for u1 in univ:
    for u2 in univ:
        if u1 != u2:
            for m1 in members[u1].keys():
                k1 = re.sub('^\s*http:\S+','',m1)
                for m2 in members[u2].keys():
                    if m2 < m1:
                        continue
                    k2 = re.sub('^\s*http:\S+','',m2)
                    d = dist(k1,k2)
                    if d < .3:
                        if not header:
                            print("Possible Duplictes:")
                            header = True
                        #print("Dist:",d)
                        ku1 = re.sub(r'https?://\S+\s*','',u1)
                        ku2 = re.sub(r'https?://\S+\s*','',u2)
                        print("  ",k1,"at",ku1)
                        print("  ",k2,"at",ku2)
                        print()
#print(dist("Steve Brandt","Steven R. Brandt"))
