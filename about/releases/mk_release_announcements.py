#!/usr/bin/python3
import sys, re, os, markdown
from bs4 import BeautifulSoup
import bs4
from datetime import datetime

def iter(tag,fd):
    if type(tag) == bs4.element.Tag:
       for t in tag:
           mktext(t,fd)
    elif type(tag) == bs4.BeautifulSoup:
       for t in tag:
         mktext(t,fd)
    elif type(tag) == bs4.element.NavigableString:
       print(reform(tag.strip()),sep='',end='',file=fd)
    else:
        assert False,'type='+str(type(tag))

del_indent = 2
indent = -del_indent

def reform(txt):
    if indent < 0:
        return txt
    txt = re.sub(r'\s+',' ',txt)
    pat = r'.{1,%d}\s*' % (80-indent)
    pstr = ''
    for p in re.findall(pat,txt):
        if indent > 0 and len(pstr) > 0:
            pstr += '\n'+(' '*indent)+'  '
        pstr += p
    return pstr

def mktext(tag,fd):
    global indent
    if tag.name == "ul":
        print(file=fd)
        indent += del_indent
        iter(tag,fd)
        indent -= del_indent
    elif tag.name == "h1":
        print("===",tag.get_text().strip(),"===",file=fd)
    elif tag.name == "h2":
        print(file=fd)
        print(file=fd)
        print("==",tag.get_text().strip(),"==",file=fd)
    elif tag.name == "li":
        print(" "*indent+"* ",end='',file=fd)
        iter(tag,fd)
        print(file=fd)
    elif tag.name == "p":
        iter(tag,fd)
        print(file=fd)
        print(file=fd)
    else:
        iter(tag,fd)

g = re.match(r'^(.*)\.md',sys.argv[1])
assert g
base_name = g.group(1)

with open(sys.argv[1],"r") as fd:
    html = markdown.markdown(fd.read())
    with open(base_name+".html","w") as fw:
        print("""
<!DOCTYPE html>

<html lang="en">
<head>
  <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
  <script src="../../head.js" type="text/javascript"></script>
  <title>{date}</title>
</head>

<body>
  <header>
    <script src="../../menu.js" type="text/javascript">
    </script>
  </header>


  <div class="container">
    <div class="row">
      <div class="col-lg-12 section">""".format(date=datetime.now().strftime("%B %d, %Y")),file=fw)
        print(html,file=fw)
        print("""
        <script src="../../footer/footer.js" type="text/javascript">
        </script>
      </div>
    </div>
  </div>
</body>
</html>
        """,file=fw)
    bs = BeautifulSoup(html,features="html.parser")
    with open(base_name+".txt","w") as fw:
        mktext(bs,fw)
