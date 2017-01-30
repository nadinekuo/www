import os

# file to visualize
h5file = "rho.xy.h5"
# size of viewport in movie
mvmax = 70.
# title to be displayed
plotTitle = "Rest Mass Density [1/Msun^2]"

OpenDatabase(h5file)
AddPlot("Pseudocolor", "HYDROBASE--rho")
p = PseudocolorAttributes()
p.centering = p.Zonal
p.limitsMode = p.CurrentPlot
p.colorTableName = "orangehot"
p.scaling = p.Log
p.minFlag = 1
p.min = 1e-11
p.maxFlag = 1
p.max = 1e-3
SetPlotOptions(p)

AddOperator("Project")

# replicate data for 180deg symmetry
AddOperator("Clip")
clip = ClipAttributes()
clip.planeInverse = 1
clip.plane1Status = 1
clip.plane2Status = 0
clip.plane1Origin = (1e-3,0,0)
SetOperatorOptions(clip)

AddOperator("Reflect")
r = ReflectAttributes()
r.useXBoundary = 0
r.useYBoundary = 0
r.useZBoundary = 0
r.reflections = (1,0,0,1,0,0,0,0)
SetOperatorOptions(r)

AddOperator("Box")
b = BoxAttributes()
b.maxx =  mvmax
b.minx = -mvmax
b.maxy =  mvmax
b.miny = -mvmax
b.maxz =  mvmax
b.minz = -mvmax
SetOperatorOptions(b)

v = GetView2D()
v.viewportCoords = (0.2, 0.95, 0.15, 0.90)
v.windowCoords = (-mvmax,mvmax,-mvmax,mvmax)
SetView2D(v)

plottitle=CreateAnnotationObject("Text2D")
plottitle.position=(0.35,0.91)
plottitle.fontFamily = plottitle.Times
plottitle.text=plotTitle

s = SaveWindowAttributes()
s.format = s.PNG
s.outputDirectory = ""
s.width, s.height = (640,480)
s.resConstraint = s.EqualWidthHeight
s.screenCapture = 0
s.family = 0
SetSaveWindowAttributes(s)

DrawPlots()

frame=0
for state in range(0,TimeSliderGetNStates()):
    if ( SetTimeSliderState(state)==0 ): # forcible replot if an error occured
        DrawPlots()
    for i in range(4): # slow down framerate by generating duplicate frames
      s.fileName = "rho_%09d" % frame
      SetSaveWindowAttributes(s)
      SaveWindow()
      frame += 1

DeleteAllPlots()
CloseDatabase(h5file)
CloseComputeEngine()

try:
    os.system("ffmpeg -i 'rho_%09d.png' -pix_fmt yuv420p -vcodec libx264 -crf 22 -threads 0 -preset slow 'rho.mp4'")
except:
    pass

# this is actually fairly bad quality
try:
    os.system("ffmpeg -r 24 -i 'rho_%09d.png' -vcodec theora -q:v 4 -threads 0 -r 6 'rho.ogv'")
except:
    pass

exit()
