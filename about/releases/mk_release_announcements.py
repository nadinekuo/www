#!/usr/bin/python3
import sys, re, os, markdown
from bs4 import BeautifulSoup
from datetime import datetime

def mktext(tag,fd):
    if type(tag) == str:
        print(tag.strip(),end='',file=fd)
    elif tag.name == "ul":
        print(file=fd)
        for t in tag:
            mktext(t,fd)
    elif tag.name == "h1":
        print("===",tag.get_text().strip(),"===",file=fd)
    elif tag.name == "h2":
        print(file=fd)
        print(file=fd)
        print("==",tag.get_text().strip(),"==",file=fd)
    elif tag.name == "li":
        print(" *",tag.get_text().strip(),file=fd)
    elif tag.name == "p":
        print(file=fd)
        print(tag.get_text().strip(),file=fd)
    else:
        for t in tag:
            mktext(t,fd)

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
