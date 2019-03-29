#!/usr/bin/python3
import sys, os, re, markdown
from bs4 import BeautifulSoup
from datetime import datetime


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
    # install via: apt-get install html2text
    cmd = "html2text -width 72 -utf8 -style pretty -rcfile {html2textrc} -o {base_name}.txt". \
        format(html2textrc = os.path.join(os.path.dirname(base_name),"html2textrc"),
               base_name = base_name)
    with os.popen(cmd, "w") as fw:
        # the python package html2text is unfortunately not an equivalent to
        # the html2text script since it does not handle wrapping of list items
        # (or at least only does so in the newest version it seems)
        print(html,file=fw)
