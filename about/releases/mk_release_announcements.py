#!/usr/bin/python3
import sys, os, re, markdown
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

def make_text(manual_breaks, fw):
  with open(sys.argv[1], "r", encoding='ascii') as fd:
      for line in fd.readlines():
          line = line.strip()

          # Ensure there are no weird characters
          n = 0
          for ch in line:
              assert re.match(r'^[=$\+\&`\[\]\(\);,?\./" \t\w:\*\#-]+$',ch), line[0:n]+"<"+ch+":"+str(ord(ch))+">"+line[n+1:]
              n += 1

          if len(line) == 0:
              indent = 0
          elif line[0] == '-':
              indent = 2
          elif line[0] == '*':
              indent = 1
          else:
              indent = 0

          line = re.sub(r'\[([^\]]*)\]\(([^\)]*)\)',r'\1',line)
          line = re.sub(r'^#+\s+','',line)

          if line == '' or not manual_breaks:
              print(line,file=fw)
              continue

          sp = ' '*(2*indent-1)
          for g in re.finditer(r'.{0,80}(\s+|$)',line):
              segment = g.group(0)
              if segment == '':
                  break
              print(sp, segment, sep='', file=fw)
              if indent > 0:
                  sp = ' '*(2*indent+1)

with open(base_name+".txt","w") as fw:
    make_text(manual_breaks=False, fw=fw)

with open(base_name+".email.txt","w") as fw:
    make_text(manual_breaks=True, fw=fw)
