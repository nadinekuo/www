---
layout: default
---
<script src="jwplayer/jwplayer.js" type="text/javascript"> </script>

<!-- markdown="1" is needed to get markdown inside of the div -->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 section" markdown="1">

Gallery: Binary, inspiraling neutron stars forming a hypermassive neutron star
==============================================================================

This simulation shows how to evolve a pair of neutron stars, reading in initial
data provided by the [LORENE](http://www.lorene.obspm.fr/) code. The video shows the rest mass density in
an equatorial slice of the simulation. The emitted gravitational waves of the
inspiral and due to the oscillations in the formed hypermassive neutron star
are shown as well.

| Parameter file        | [NsNsToHMNS.par](nsnstohmns.par) |
| Thornlist             | [NsNsToHMNS.th](NsNsToHMNS.th) (Thorn NSTracker added to release) |
| Initial data file     | [G2_I12vs12_D4R33T21_45km.resu.xz](G2_I12vs12_D4R33T21_45km.resu.xz) (uncompress using unxz) |
| Support scripts       | [scripts.tar.gz](scripts.tar.gz) |
| approx. memory        | 8.8 GB |
| approx. runtime       | 12\*48 SU |

<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12 section" markdown="1">

![Psi_4^{2,2} at r=300M over time](mp_Psi4_l2_m2_r300.00.png)

</div>

<div class="col-lg-12 col-md-8 col-sm-8 col-xs-12 section">
  <div id="NsNsToHMNS_rho">
    Loading the player...
    Download movie: <a href="rho.mp4">rho.mp4</a> 
    <br>
    <script type="text/javascript">
    jwplayer("NsNsToHMNS_rho").setup({
      file: "rho.mp4",
      image: "rho.png",
      width: 640, height: 480
    });
    </script> 
  </div>
</div>

</div>
