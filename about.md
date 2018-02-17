---
layout: default
---

<a class='local_anchor' id="top"> </a>
# About the Einstein Toolkit

<div class="col-sm-3" markdown="1">
Find out what you can do using the Einstein Toolkit. Have a look at its
<br/>
<a class="btn btn-info" href="#capabilities" role="button">Capabilities</a>
</div>

<div class="col-sm-3" markdown="1">
The Einstein Toolkit is not a monolithic code, but contains various
<br/>
<a class="btn btn-info" href="#components" role="button">Components</a>
</div>

<div class="col-sm-3" markdown="1">
Not just any code can be included in the Einstein Toolkit. More about this in
our
<br/>
<a class="btn btn-info" href="#guidelines" role="button">Guidelines</a>
</div>

<div class="col-sm-3" markdown="1">
Users of the Einstein Toolkit are encouraged to register to become one of
its
<br/> <!--TODO: fix the forced line break, eg via style='display:block;'-->
<a class="btn btn-info" href="#members" role="button">Members</a>
</div>

<div class="col-xs-12" data-shorthand="About the ET" markdown="1">

## What is the Einstein Toolkit?
__The Einstein Toolkit is a [community](members.html)-driven software platform
of core computational tools to advance and support research in relativistic
astrophysics and gravitational physics.__

We are developing and supporting open software for relativistic astrophysics.
Our aim is to provide the core computational tools that can enable new science,
broaden our community, facilitate interdisciplinary research and take advantage
of emerging petascale computers and advanced cyberinfrastructure.

The Einstein Toolkit aims to include any computational tool the fits into it's
scope. Currently, a large portion of the toolkit is made up by over 100
[Cactus](http://www.cactuscode.org) components (called thorns) for
computational relativity along with associated tools for simulation management
and visualization. This includes a vacuum spacetime solver (McLachlan), two
relativistic hydrodynamics solvers (GRHydro and IllinoisGRMHD), along with
components for initial data, analysis and computational infrastructure. These
components have been developed and improved over many years by [many different
researchers](maintainers-credits.html).

The Einstein Toolkit is supported by a distributed model, combining core
support of software, tools, and documentation with partnerships with other
developers who contribute open software and coordinate together on development.

The tools and thorns comprising the Einstein Toolkit are provided in this
[Component List](https://bitbucket.org/einsteintoolkit/manifest/raw/ET_2018_02/einsteintoolkit.th).
A [tutorial](http://docs.einsteintoolkit.org/et-docs/Tutorial_for_New_Users)
describes in easy steps how to download, compile, and run this resoluting code.

</div>

<!-- Capabilities -->
<div class="section col-xs-12" data-shorthand="Capabilities of the ET" markdown="1">
<a class='local_anchor' id="capabilities">[back](#top)</a>
## Capabilities

### Vacuum Spacetimes
Evolution of vacuum spacetime is provided by the McLachlan code. McLachlan solves the Einstein vacuum equations in 3D Cartesian coordinates using adaptive mesh refinement
and can be combined with matter codes for modeling spacetimes containing
matter. McLachlan is implemented using the Kranc package. Features of McLachlan
include:

  * complete implementation of the BSSNOK general relativity spacetime
    evolution equations including all the standard tricks that ensures
    stability
  * up-winding for the shift advection terms
  * standard moving puncture Gamma-driver and 1 + log gauges
  * phi- and W- methods
  * static and radiative outer boundary conditions
  * inclusion of matter through the TmunuBase interface
  * up to 8th order finite differencing
  * OpenMP parallelization through Carpet/LoopControl in addition to MPI
    parallelization through Carpet
  * multi-block code infrastructures by applying the Jacobian to transform
    local derivatives to global derivatives

### Relativistic Magneto&#8203;hydrodynamics
#### GRHydro
The Einstein Toolkit GRHydro modules can evolve spacetimes with general
relativistic hydrodynamics in 3D Cartesian coordinates. GRHydro was once based
on the public version of the [Whisky code](http://www.whiskycode.org/)
developed originally by the EU Network on Sources of Gravitational Radiation
and later by a collaboration led by AEI/SISSA, but was later expanded and
cleaned up considerably. Features of GRHydro include at the moment:

  * Evolution of the equations of general relativistic magneto-hydrodynamics
    (GRMHD) in 3D Cartesian coordinates on a curved dynamical background.

#### IllinoisGRMHD
IllinoisGRMHD solves the equations of General Relativistic MagnetoHydroDynamics
(GRMHD) using a high-resolution shock capturing scheme. It is a rewrite of the
Illinois Numerical Relativity (ILNR) group's GRMHD code, and generates results
that agree to roundoff error with that original code. Its feature set coincides
with the features of the ILNR group's recent code (ca. 2009--2014), which was
used in their modeling of the following systems:

  * Magnetized circumbinary disk accretion onto binary black holes
  * Magnetized black hole--neutron star mergers
  * Magnetized Bondi flow, Bondi-Hoyle-Littleton accretion
  * White dwarf--neutron star mergers

IllinoisGRMHD is particularly good at modeling GRMHD flows into black holes
without the need for excision. Its HARM-based conservative-to-primitive solver
has also been modified to check the physicality of conservative variables prior
to primitive inversion, and move them into the physical range if they become
unphysical.

### Initial Data
  * Single and binary black holes
  * Single TOV stars
  * LORENE data

### Relativity Tools
  * Apparent horizon finding
  * Black hole excision

### Analysis
  * TrK, det(g), R_ab, R
  * ADM constraint violation
  * Basic hydrodynamics analysis routines
  * Extraction of gravitational waves

### Computational Infrastructure
  * Adaptive mesh refinement
  * Reflection and rotation symmetry boundary conditions
  * Radiation boundary conditions
  * Flexible Cartesian 3-D meshes
  * Multidimensional I/O using HDF5, ASCII, Jpegs
  * Method of lines time integration
  * Courant time steeping
  * Seamless use of BLAS, GSL, HDF5, LAPACK

### Tools
  * Checking for NaNs
  * Memory poisoning to identify uninitialized variables
  * Timing report by thorn, schedule bin, and method

</div>


<!-- Components -->
<div class="section col-xs-12" data-shorthand="Components of the ET" markdown="1">
<a class='local_anchor' id="components">[back](#top)</a>
## Components of the Einstein Toolkit include

<dl class="col-grid">
<dt class="col-sm-3 col-md-2 hline">Cactus Framework</dt>
<dd class="col-sm-9 col-md-10 hline" markdown="1">
The [Cactus Framework and Computational Toolkit](http://www.cactuscode.org)
provides an parallel, collaborative, component framework for the Einstein
Toolkit.  Cactus was developed by the numerical relativity community but now
supports scientific applications in different disciplines. The Cactus
Computational Toolkit is a set of thorns that provide general capabilities used
by the Einstein Toolkit such as I/O, coordinates and boundary conditions.
Distribution: The Cactus Framework is distributed under an open source license
from the Cactus website [http://www.cactuscode.org](http://www.cactuscode.org)
</dd>
<dt class="col-sm-3 col-md-2 hline">Component Lists and GetComponents</dt>
<dd class="col-sm-9 col-md-10 hline" markdown="1">
The Einstein Toolkit component list contains the locations of the source code
and associated tools for simulations, including Cactus thorns. The component
list is written using the Component Retrieval Language and can be checked out
using the
[GetComponents](https://github.com/gridaphobe/CRL/raw/ET_2018_02/GetComponents)
tools. Distribution:
[https://github.com/gridaphobe/CRL/raw/ET_2018_02/GetComponents](https://github.com/gridaphobe/CRL/raw/ET_2018_02/GetComponents)
</dd>
<dt class="col-sm-3 col-md-2 hline">Simulation Factory</dt>
<dd class="col-sm-9 col-md-10 hline" markdown="1">
The [simulation factory](http://www.cct.lsu.edu/~eschnett/SimFactory/) includes
configuration and batch script files for compiling and running simulations
using the Cactus code on many different architectures. Additional capabilities
provide for management of simulations, simplifying checkpoint &amp; restart,
and remote use of machines. The Einstein Consortium have selected the
simulation factory as the default mechanism for supporting the easy use of
Cactus on heterogeneous resources.  Distribution: Bitbucket git repository:
[https://bitbucket.org/simfactory/simfactory2](https://bitbucket.org/simfactory/simfactory2)
(ET_2018_02 branch)
</dd>
<dt class="col-sm-3 col-md-2 hline">Cactus Thorns</dt>
<dd class="col-sm-9 col-md-10 hline" markdown="1">
Code for the centrally supported Cactus thorns in the Einstein Toolkit.
Additional thorns are maintained in external repositories with open access.
Distribution: Bitbucket: [Cactuscode](https://bitbucket.org/cactuscode) and
[Einstein Toolkit](https://bitbucket.org/einsteintoolkit). Some components are
also live in the Einstein Toolkit SVN repository, an overview of which is here,
but includes also components that now moved to Bitbucket:
[https://svn.einsteintoolkit.org/cactus/](https://svn.einsteintoolkit.org/cactus)
</dd>
<dt class="col-sm-3 col-md-2 hline">Parameter Files</dt>
<dd class="col-sm-9 col-md-10 hline" markdown="1">
Example Cactus code parameter files for Einstein Toolkit beginners. Simple
examples are provided for a Kerr-Schild black hole, a binary black hole
coalescence, and a static TOV star. See the documentation for information on
how to run these on the QueenBee 2 machine. Distribution:
[Cactuscode](https://bitbucket.org/cactuscode/cactusexamples) and
[EinsteinToolkit](https://bitbucket.org/einsteintoolkit/einsteinexamples)
(choose ET_2018_02 branch for both).
</dd>
</dl>

</div>

<!-- Guidelines -->
<div class="section col-xs-12" data-shorthand="Guidelines" markdown="1">
<a class='local_anchor' id="guidelines">[back](#top)</a>
## Guidelines

The Einstein Toolkit is a collection of software components and tools for
simulating and analyzing general relativistic astrophysical systems. Such
systems include gravitational wave space-times, collisions of compact objects
such as black holes or neutron stars, accretion onto compact objects, core
collapse supernovae and Gamma-Ray Bursts.

The Einstein Toolkit builds on numerous software efforts in the numerical
relativity community including CactusEinstein,
[Whisky](http://www.whiskycode.org/), and [Carpet](http://www.carpetcode.org).
The Einstein Toolkit currently uses the
[Cactus Framework](http://www.cactuscode.org) as the underlying computational
infrastructure that provides large-scale parallelization, general computational
components, and a model for collaborative, portable code development.

<!-- TODO: turn this into a heading -->
<!-- TOOD: define semantics for principles -->
**Guiding principles for the design and implementation of the toolkit include:**

 * _**Open, community-driven software development** that encourages the sharing of code across the community, prevents code duplication and leads to sustainable support
and development of essential code._
 * _**Well thought out and stable interfaces** between components that enable multiple implementations of physics capabilities, and allow groups or individuals to
concentrate on their areas of interest._
 * _**Separation of physics software from computational science infrastructure** so that new technologies for large scale computing, processor accelerators, or parallel
I/O can be easily integrated with science codes._
* _The provision of **complete working production codes** to provide: prototypes, standard benchmarks and testcases; codes that are available for and usable by the
general astrophysics community; tools for new researchers and groups to enter this field; training and education for a new generation of researchers._

The Toolkit includes a set of mix-and-match components (or Thorns) that support the development of codes for relativistic astrophysics. A number of full examples provide
prototype, production examples of complete astrophysical codes including black hole spacetimes and relativistic hydrodynamical spacetimes.

The Einstein Toolkit uses a distributed model with its software modules either developed, distributed and supported by the [core maintainers](maintainers-credits.html) team, or by
individual groups. Where modules are provided by external groups, we provide quality control for modules for inclusion in the toolkit and help coordinate support.

Through this effort we want to catalyze a consortium for the development and support for community infrastucture for relativistic astrophysics. Although currently the
toolkit is based on Cactus, in the future we plan for the consortium to support other relevant community codes. In the shorter term we are building on the toolkit and
interested in tools that interface with Cactus for initial data, post-processing and visualization.

</div>

<!-- Memmbers -->
<!-- TODO: find out what script generates these -->

<div class="section col-xs-12" data-shorthand="Members" markdown="1">
<a class='local_anchor' id="members">[back](#top)</a>
# Einstein Toolkit Members

We are building a consortium of users and developers for the Einstein Toolkit.
Users of the Einstein Toolkit are encouraged to [register on this
page](join.html).

<div> <!-- disables markdown -->
<script type="text/javascript">
  var membersFile = new XMLHttpRequest();
  membersFile.open("GET", "members.txt", false);
  membersFile.send();
  var toInsert = "";
  var nMembers = 0;
  var nInst    = 0;
  if (membersFile.status === 200) {
    lines = membersFile.responseText.split("\n");
    var pi=0;
    for (var i = 0; i < lines.length; i++) {
      if (lines[i].length > 0) {
        // Person
        if (lines[i].substring(0,1) === " ") {
          if (pi==0) {
            toInsert += "    <div class='col-sm-6'>\n";
            toInsert += "     <ul class='members'>\n";
          }
          words = lines[i].split(" ");
          if (words[1].length > 4 && words[1].substring(0, 4) === "http") {
            link = words[1];
            name = words.slice(2).join(" ");
            toInsert += "      <li><a href='" + link + "'>" + name + "</a></li>\n";
          } else {
            toInsert += "      <li>"+lines[i]+"</li>\n";
          }
          nMembers++;
          pi++;
        // Institute
        } else {
          if (i>0) {
            toInsert += "     </ul>\n    </div>\n   </div>\n   <hr class='members'/>\n";
          }
          toInsert += "   <div class='row'>\n";
          toInsert += "    <div class='col-sm-6'>";
          words = lines[i].split(" ");
          if (words[0].length > 4 && words[0].substring(0, 4) === "http") {
            link = words[0];
            name = words.slice(1).join(" ");
            toInsert += "<a href='" + link + "'>" + name + "</a>";
          } else {
            toInsert += lines[i];
          }
          toInsert += "</div>\n";
          pi = 0;
          nInst++;
        }
      }
    }
    toInsert += "     </ul>\n    </div>\n   </div>\n   <br>\n";
    toInsert += "<p>These add up to "+nMembers+" members from "+nInst+" different groups.</p>";
  } else {
    toInsert = "Error: could not get members data";
  }

  document.write(toInsert);
</script>
</div>

</div>
[back](#top)
