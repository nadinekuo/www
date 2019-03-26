# Release Announcement

We are pleased to announce the seventeenth release (code name ["Proca"](https://en.wikipedia.org/wiki/Alexandru_Proca)) of the
Einstein Toolkit, an open, community developed software infrastructure for
relativistic astrophysics. The highlights of this release are

New arrangements and thorns have been added:

* Proca
 * NPScalars_Proca
 * ProcaBase
 * ProcaEvolve
 * Proca_simpleID
 * TwoPunctures_KerrProca
* lean_public
 * LeanBSSNMoL
 * NPScalars
* wvuthorns_diagnostics
 * particle_tracerET
 * Seed_Magnetic_Fields_BNS
 * smallbPoynET
 * VolumeIntegrals_GRMHD
 * VolumeIntegrals_vacuum

In addition, bug fixes accumulated since the previous release in Nov 2018
have been included.

The Einstein Toolkit is a collection of software components and tools for
simulating and analyzing general relativistic astrophysical systems that builds
on numerous software efforts in the numerical relativity community including
CactusEinstein, the Carpet AMR infrastructure and the relativistic
magneto-hydrodynamics code GRHydro. For parts of the toolkit, the Cactus
Framework is used as the underlying computational infrastructure providing
large-scale parallelization, general computational components, and a model for
collaborative, portable code development. The toolkit includes modules to build
complete codes for simulating black hole spacetimes as well as systems governed
by relativistic magneto-hydrodynamics.

The Einstein Toolkit uses a distributed software model and its different
modules are developed, distributed, and supported either by the core team of
Einstein Toolkit Maintainers, or by individual groups. Where modules are
provided by external groups, the Einstein Toolkit Maintainers provide quality
control for modules for inclusion in the toolkit and help coordinate support.
The Einstein Toolkit Maintainers currently involve postdocs and faculty from
six different institutions, and host weekly meetings that are open for anyone
to join in.

Guiding principles for the design and implementation of the toolkit include:
open, community-driven software development; well thought out and stable
interfaces; separation of physics software from computational science
infrastructure; provision of complete working production code; training and
education for a new generation of researchers.

For more information about using or contributing to the Einstein Toolkit, or to
join the Einstein Toolkit Consortium, please visit our web pages at
http://einsteintoolkit.org.

The Einstein Toolkit is primarily supported by NSF
1550551/1550461/1550436/1550514 (Einstein Toolkit Community Integration and
Data Exploration).

The Einstein Toolkit contains about 400 regression test cases.  On a large
portion of the tested machines, almost all of these tests pass, using both
MPI and OpenMP parallelization.

The changes between this and the previous release include:

## Larger changes since last release

## How to upgrade from Chien-Shiung Wu (ET_2018_09) 

To upgrade from the previous release, use GetComponents with the new thornlist
to check out the new version.

See the Download page (http://einsteintoolkit.org/download/) on the
Einstein Toolkit website for download instructions.

## Machine notes

Supported (tested) machines include:

- Default Debian, Ubuntu, Fedora, CentOS, Mint, OpenSUSE and MacOS (Homebrew and MacPorts) installations
- Bluewaters
- Comet
- Cori
- Edison
- Golub
- Marconi
- Queenbee 2
- Stampede 2
- SuperMIC
- SuperMike
- Wheeler

* TACC machines: defs.local.ini needs to have sourcebasedir = $WORK
  and basedir = $SCRATCH/simulations configured for this machine.  You
  need to determine $WORK and $SCRATCH by logging in to the machine.

All repositories participating in this release carry a branch ET_2018_09
marking this release.  These release branches will be updated if severe
errors are found.

The "Proca" Release Team on behalf of the Einstein Toolkit Consortium
(2019-03-31)

* Steven R. Brandt
* Samuel D. Cupp
* Peter Diener
* Roland Haas
* Roberto De Pietri
* Helvi Witek

Mar, 2019
