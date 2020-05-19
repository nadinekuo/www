#!/usr/bin/python3
import sys, os, re, markdown
from datetime import datetime

def readlines(fd):
    """Read lines from file discarding comments at beginning"""
    lines = []
    for line in fd:
        if not lines and re.match("^ *%", line):
            continue # skip comments at beginning of file
        lines.append(line)
    return lines

g = re.match(r'^(.*)\.md',sys.argv[1])
assert g
base_name = g.group(1)

with open(sys.argv[1],"r") as fd:
    html = markdown.markdown("\n".join(readlines(fd)))
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
  textwidth = 72 # maxium allowed length including indentation
  with open(sys.argv[1], "r", encoding='ascii') as fd:
      for line in readlines(fd):
          line = line.strip()

          # Ensure there are no weird characters
          n = 0
          for ch in line:
              assert re.match(r'^[=$\+\&`\[\]\(\)\{\}@;,?\./" \t\w:\*\#\'-]+$',ch), line[0:n]+"<"+ch+":"+str(ord(ch))+">"+line[n+1:]
              n += 1

          if len(line) == 0:
              indent = 0
              linewidth = textwidth
          elif line[0] == '-':
              indent = 2
              linewidth = textwidth - (2*indent+1)
          elif line[0] == '*':
              indent = 1
              linewidth = textwidth - (2*indent+1)
          else:
              indent = 0
              linewidth = textwidth

          line = re.sub(r'\[([^\]]*)\]\(([^\)]*)\)',r'\1',line)
          line = re.sub(r'^#+\s+','',line)
          line = re.sub(r'`([^`\s]*)`',r'\1',line)

          sp = ' '*(2*indent-1)

          if line == '' or not manual_breaks:
              print(sp,line,sep='',file=fw)
              continue
          # The regular expression {0,N} greedily looks
          # for matches of at most N characters.
          while True:
              g = re.match(r'(.{1,%d})(\s+|$)' % (linewidth-len(sp)), line)
              if not g:
                  break
              segment = g.group(0)
              line = line[g.end(0):]

              # Don't generate an extra newline for
              # the last blank pattern match.
              if segment == '':
                  break

              # A list gets a different indentation
              # on the continuation line because we
              # want to indent past the bullet.
              print(sp, segment.rstrip(), sep='', file=fw)
              if indent > 0:
                  sp = ' '*(2*indent+1)

with open(base_name+".txt","w") as fw:
    make_text(manual_breaks=False, fw=fw)

with open(base_name+".email.txt","w") as fw:
    make_text(manual_breaks=True, fw=fw)
