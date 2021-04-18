import numpy as np
data = np.genfromtxt("refwaveform.csv", delimiter=',')
data2 = np.genfromtxt("waveform.csv", delimiter=',')
import matplotlib.pyplot as plt
fig = plt.figure()
ax = fig.add_subplot(111)
ax.set_aspect(400)
plt.xlabel('(t-r*)/M')
plt.ylabel('Re[h+^(2,2)]')
#plt.xticks([-10,-5,0,5,10])
plt.ylim(-.5,.5)
plt.xlim(0,1000)
plt.plot(data[:,0],data[:,1],'b-',label='Zenodo')
plt.plot(data2[:,0],data2[:,1],'y--',label='Recent Run')
plt.title("Waveform Comparison")
plt.legend()
#plt.show()
plt.savefig("waveform-comparison.png")