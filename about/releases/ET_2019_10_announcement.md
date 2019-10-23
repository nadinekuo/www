# Release Announcement

We are pleased to announce the nineteenth release (code name ["Mayer"](https://en.wikipedia.org/wiki/Maria_Goeppert_Mayer)) of the Einstein Toolkit, an open, community developed software infrastructure for relativistic astrophysics. The highlights of this release are:

A new thorn has been added:

* FishboneMoncriefID

Also, for the first time, a new code has been added.

* [SelfForce-1D](https://bitbucket.org/peterdiener/selfforce-1d.git)

The ETK is embracing a new model of assigning credit:

 * Until now, the 2012 Einstein Toolkit paper was the primary way to cite the Cactus-based collection if infrastructure and physics thorns. In this release, however, we will begin using a DOI to recognize the many contributers that have worked on the toolkit since that time.

In principle, the Einstein Toolkit was always intended to be a collection of codes for exploring numerical relativity, not simply a collection of arrangements and thorns for the Cactus Framework. Going forward, SelfForce-1D will have regular releases using the same release tags as the Cactus-based codes, and will have a similar setup for the running of test-suites. While the the new code will not download at the same time as the Cactus-based code, download instructions will appear in the same places.

In addition, bug fixes accumulated since the previous release in March 2019 have been included.

The Einstein Toolkit is a collection of software components and tools for simulating and analyzing general relativistic astrophysical systems that builds on numerous software efforts in the numerical relativity community including CactusEinstein, the Carpet AMR infrastructure and the relativistic magneto-hydrodynamics codes GRHydro and IllinoisGRMHD. For parts of the toolkit, the Cactus Framework is used as the underlying computational infrastructure providing large-scale parallelization, general computational components, and a model for collaborative, portable code development. The toolkit includes modules to build complete codes for simulating black hole spacetimes as well as systems governed by relativistic magneto-hydrodynamics.

The Einstein Toolkit uses a distributed software model and its different modules are developed, distributed, and supported either by the core team of Einstein Toolkit Maintainers, or by individual groups. Where modules are provided by external groups, the Einstein Toolkit Maintainers provide quality control for modules for inclusion in the toolkit and help coordinate support. The Einstein Toolkit Maintainers currently involve postdocs and faculty from six different institutions, and host weekly meetings that are open for anyone to join in.

Guiding principles for the design and implementation of the toolkit include: open, community-driven software development; well thought-out and stable interfaces; separation of physics software from computational science infrastructure; provision of complete working production code; training and education for a new generation of researchers.

For more information about using or contributing to the Einstein Toolkit, or to join the Einstein Toolkit Consortium, please visit our web pages at http://einsteintoolkit.org.

The Einstein Toolkit is primarily supported by NSF 1550551/1550461/1550436/1550514 (Einstein Toolkit Community Integration and Data Exploration).

The Einstein Toolkit contains about 400 regression test cases.  On a large portion of the tested machines, almost all of these tests pass, using both MPI and OpenMP parallelization.

The changes between this and the previous release include:

## Larger changes since last release

* The Fishbone Moncrief Initial Data thorn (FishboneMoncriefID) thorn
  has been added to the wvuthorns arrangement.
  {ZACH INCLUDE TEXT}
* The inclusion of the SelfForce-1D code in the Einstein Toolkit as the
  first non-Cactus code in the toolkit.
    - Evolves the sourced scalar wave equation on a Schwarzschild spacetime
      using the effective source approach to point particles.
    - The wave equation is decomposed into spherical harmonics and the
      resulting 1+1 dimensional equations are discretized in the radial
      direction using the discontinuous Galerkin method.
* Update hwloc to 1.11.12
* Groups of vectors of vectors are now handled properly by RotatingSymmetry90 and RotatingSymmetry180
* Compilation of PAPI is faster and produces fewer warnings


## How to upgrade from Proca (ET_2019_03) 

To upgrade from the previous release, use GetComponents with the new thornlist to check out the new version.

See the Download page (http://einsteintoolkit.org/download/) on the Einstein Toolkit website for download instructions.

## Machine notes

Supported (tested) machines include:

- Default Debian, Ubuntu, Fedora, CentOS 7, Mint, OpenSUSE and MacOS (MacPorts) installations
- Bluewaters
- Comet
- Cori
- Stampede 2
- Mike

* TACC machines: defs.local.ini needs to have sourcebasedir = $WORK
  and basedir = $SCRATCH/simulations configured for this machine.  You
  need to determine $WORK and $SCRATCH by logging in to the machine.

All repositories participating in this release carry a branch ET_2019_10 marking this release.  These release branches will be updated if severe errors are found.

The "Mayer" Release Team on behalf of the Einstein Toolkit Consortium (2019‐10‐25)

* Steven R. Brandt
* Maria Babiuc-Hamilton
* Peter Diener
* Zachariah Etienne
* Roland Haas
* Helvi Witek
* {Helvi's Students}

Oct, 2019
