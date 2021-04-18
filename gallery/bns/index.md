---
layout: default
---
<!-- markdown="1" is needed to get markdown inside of the div -->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 section" markdown="1">

Gallery: Binary, inspiraling neutron stars forming a hypermassive neutron star
==============================================================================

This simulation shows how to evolve a pair of neutron stars, reading in initial
data provided by the [LORENE](http://www.lorene.obspm.fr/) code. The video shows the rest mass density in
an equatorial slice of the simulation. The emitted gravitational waves of the
inspiral and due to the oscillations in the formed hypermassive neutron star
are shown as well.

| Parameter file        | [nsnstohmns.par](nsnstohmns.par) | |
| Thornlist             | [nsnstohmns.th](nsnstohmns.th) | Use wit `./GetComponents  http://einsteintoolkit.org/gallery/bns/nsnstohmns.th` to dowload the code and compile using `simfactory/bin/sim build --thornlist thornlists/nsnstohmns.th` once downloaded.  This thornlist contains the thorns of the Einstein Toolkit as well as the thorn `NSTracker` which is not part of the Einstein Toolkit yet. |
| Initial data file     | [G2_I12vs12_D4R33T21_45km.resu.xz](G2_I12vs12_D4R33T21_45km.resu.xz) | Uncompress using [unxz](http://en.wikipedia.org/wiki/XZ_Utils).|
| Support scripts       | [scripts.tar.gz](scripts.tar.gz) | |
| approx. memory        | 8.8 GB | |
| approx. runtime       | 24 hours using 12 cores | |
| Results (11MB)        | [bns-20201112.tar.gz](https://bitbucket.org/einsteintoolkit/www/downloads/bns-20201112.tar.gz) | |

This example was last tested on 12-November-2020.

<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12 section" markdown="1">

![Psi_4^{2,2} at r=300M over time](mp_Psi4_l2_m2_r300.00.png){:class="img-responsive"}

</div>

<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 section">
<video width="100%" controls preload="none" poster="rho.png">
  <source src="rho.mp4" type="video/mp4">
  <source src="rho.ogv" type="video/ogg">
  Your browser does not support the video tag.
</video>
</div>
