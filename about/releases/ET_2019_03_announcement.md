# Release Announcement

We are pleased to announce the eighteenth release (code name
["Proca"](https://en.wikipedia.org/wiki/Alexandru_Proca)) of the Einstein
Toolkit, an open, community developed software infrastructure for relativistic
astrophysics. The highlights of this release are:

New arrangements and thorns have been added:

* Proca
    - NPScalars_Proca
    - ProcaBase
    - ProcaEvolve
    - Proca_simpleID
    - TwoPunctures_KerrProca
* lean_public
    - LeanBSSNMoL
    - NPScalars
* wvuthorns_diagnostics
    - particle_tracerET
    - Seed_Magnetic_Fields_BNS
    - smallbPoynET
    - VolumeIntegrals_GRMHD
    - VolumeIntegrals_vacuum

In addition, bug fixes accumulated since the previous release in September 2018
have been included.

The Einstein Toolkit is a collection of software components and tools for
simulating and analyzing general relativistic astrophysical systems that builds
on numerous software efforts in the numerical relativity community including
CactusEinstein, the Carpet AMR infrastructure and the relativistic
magneto-hydrodynamics codes GRHydro and IllinoisGRMHD. For parts of the
toolkit, the Cactus Framework is used as the underlying computational
infrastructure providing large-scale parallelization, general computational
components, and a model for collaborative, portable code development. The
toolkit includes modules to build complete codes for simulating black hole
spacetimes as well as systems governed by relativistic magneto-hydrodynamics.

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
portion of the tested machines, almost all of these tests pass, using both MPI
and OpenMP parallelization.

The changes between this and the previous release include:

## Larger changes since last release

* The Proca arrangement has been added: This repository provides the tools to
* evolve the Einstein-Proca system as first described in
* https://arxiv.org/abs/1505.00797.
    - NPScalars_Proca: Implementation of the Newman-Penrose scalars $\Psi_{0}$,
      $\Psi_{4}$ (in- and outgoing gravitational radiation) and $\Phi_{0}$,
      $\Phi_{1}$, $\Phi_{2}$ (electromagnetic radiation) to extract radiation
      emitted in BH-Proca spacetimes.
    - Proca_simpleID: Create initial data for a black hole surrounded by a
      Proca field with mass mu. This is the "Simple Initial Data" construction
      from paper "Nonlinear interactions between black holes and Proca fields",
      Miguel Zilhão, Helvi Witek, Vitor Cardoso, Class.Quant.Grav. 32 (2015)
      234003, arXiv:1505.00797 [gr-qc].
    - TwoPunctures_KerrProca: A modified TwoPunctures thorn to construct
      initial data for a single rotating black hole coupled to a massive vector
      field. The description for this construction can be found in Zilhao et al
      [arXiv:1505.00797 [gr-qc]].
* The Lean arrangement has been added: This thorns evolve Einstein's Equations
* of General Relativity with the BSSN formulation. For the conformal factor it
* uses the "W" version, i.e. W=\gamma^{-1/6}, and it employs the usual "1+log"
* and "Gamma-driver" gauge conditions. Also available, in the "new_gauge"
* branch, is the shift condition of Figueras et al for their evolutions of
* higher dimensional BHs, see: https://arxiv.org/abs/1512.04532 (eq. 3)
* https://arxiv.org/abs/1702.01755 The WVU Diagnostics arrangement has been
* added. These thorns are designed primarily to add useful diagnostics for
* binary neutron star simulations performed with IllinoisGRMHD.
    - NSNS_parameter_files Contains parameter files for magnetized and unmagnetized BNS evolutions.
    - Seed_Magnetic_Fields_BNS Extended Seed_Magnetic_Fields thorn for binary neutron stars.
    - VolumeIntegrals_GRMHD: GRMHD volume integration thorn, currently depends on IllinoisGRMHD and Carpet. Performs volume integrals on arbitrary "Swiss-cheese"-like topologies, and even interoperates with Carpet to track NS centers of mass.
    - VolumeIntegrals_vacuum: Same functionality as VolumeIntegrals_GRMHD, but designed for integration of spacetime quantities. Depends on ML_BSSN and ADMBase for integrands.
    - particle_tracerET Solves the ODE \partial_t x^i = v^i for typically thousands of tracer particles, using an RK4 integration atop the current time stepping.
    - smallbPoynET Computes b^i, b^2, and three spatial components of Poynting flux. It also computes (-1-u_0), which is useful for tracking unbound matter.
* Ticket tracking system moved to bitbucket:
* https://bitbucket.org/einsteintoolkit/tickets/ Subversion infrastructure for
* thorns is no longer maintained at LSU. Instead, the svn checkout mechanism
* supported by github.com is used. Llama supports tensorweights other than 1.0
* or 0.0 Added EinsteinAnalysis/Hydro_Analysis/Hydro_Analysis_Masses.F90 in
* order to compute the total baryonic mass and baryonic mass within user
* defined radii. A summary of changes Carpet:
    - add support for very large grids where 64bit integer are needed for grid
      indices and sizes of transfer buffers
    - fix how how physical_time_per_hour is computed
    - add functionality to align interior of grid functions to cache
      boundaries. This requires changes to Cactus and PUGH as well.
    - add a parameter "granularity" to make sure the interior of components is
      a multiple of N points in each direction
* The version of MPI bundled with the ET is now OpenMPI 1.10.7 The
* SystemTopology thorn now supports hwloc 2.0 

## How to upgrade from Chien-Shiung Wu (ET_2018_09) 

To upgrade from the previous release, use GetComponents with the new thornlist
to check out the new version.

See the Download page (http://einsteintoolkit.org/download/) on the
Einstein Toolkit website for download instructions.

## Machine notes

Supported (tested) machines include:

- Default Debian, Ubuntu, Fedora, CentOS, Mint, OpenSUSE and MacOS (MacPorts) installations
- Bluewaters
- Comet
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

All repositories participating in this release carry a branch ET_2019_03
marking this release.  These release branches will be updated if severe
errors are found.

The "Proca" Release Team on behalf of the Einstein Toolkit Consortium
(2019-03-31)

* Steven R. Brandt
* Samuel D. Cupp
* Peter Diener
* Zachariah Etienne
* Roland Haas
* Helvi Witek

Mar, 2019
