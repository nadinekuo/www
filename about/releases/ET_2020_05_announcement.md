% vim: tw=0
# Release Announcement

We are pleased to announce the twentieth release (code name ["Turing"](https://en.wikipedia.org/wiki/Alan_Turing)) of the Einstein Toolkit, an open, community developed software infrastructure for relativistic astrophysics. The highlights of this release are:

Two news thorn have been added:

 * Baikal
 * BaikalVacuum

Also, the Cactus code now supports tracking of data dependencies at runtime using schedule annotations. These can be used to check correctness of a schedule and also to automate data synchronizations between MPI ranks.

In addition, bug fixes accumulated since the previous release in October 2019 have been included.

The Einstein Toolkit is a collection of software components and tools for simulating and analyzing general relativistic astrophysical systems that builds on numerous software efforts in the numerical relativity community including the spacetime evolution codes Baikal, Leann, and McLachlan, analysis codes to compute horizon characteristics and gravitational waves, the Carpet AMR infrastructure, and the relativistic magneto-hydrodynamics codes GRHydro and IllinoisGRMHD. The Einstein Toolkit also contains a 1D self-force code. For parts of the toolkit, the Cactus Framework is used as the underlying computational infrastructure providing large-scale parallelization, general computational components, and a model for collaborative, portable code development.

The Einstein Toolkit uses a distributed software model and its different modules are developed, distributed, and supported either by the core team of Einstein Toolkit Maintainers, or by individual groups. Where modules are provided by external groups, the Einstein Toolkit Maintainers provide quality control for modules for inclusion in the toolkit and help coordinate support. The Einstein Toolkit Maintainers currently involve postdocs and faculty from six different institutions, and host weekly meetings that are open for anyone to join in.

Guiding principles for the design and implementation of the toolkit include: open, community-driven software development; well thought-out and stable interfaces; separation of physics software from computational science infrastructure; provision of complete working production code; training and education for a new generation of researchers.

For more information about using or contributing to the Einstein Toolkit, or to join the Einstein Toolkit Consortium, please visit our web pages at [http://einsteintoolkit.org](http://einsteintoolkit.org).

The Einstein Toolkit is primarily supported by NSF 1550551/1550461/1550436/1550514 (Einstein Toolkit Community Integration and Data Exploration).

The Einstein Toolkit contains about 300 regression test cases. On a large portion of the tested machines, almost all of these tests pass, using both MPI and OpenMP parallelization.

The changes between this and the previous release include:

## Larger changes since last release

* **PRESYNC** Steven R. Brandt, Samuel Cupp: please add somethine here
* **Baikal** Zachariah Etienne: please add something here
* ExternalLibraries
    - the HDF5 tarball included in the EinsteinToolkit has been updated to 1.10.5, which changed the hid_t types to 64 integers
    - the hwloc tarball included in the EinsteinToolkit has been updated to 2.0.1, which is incompatible with version 1.X
* new features and enhancements
    - thorn Vectors now supports vectorization on IBM POWER9 cpus used in Summit
    - Carpet will allocate less memory if `enable_no_storage = yes`, which is useful when testing parameter files using `cactus_sim -P parfile.par`
    - CarpetLib speedup during regridding by removing expensive debug checks
    - temperature finding for tabulated EOS in EOS_Omni become more robust for situations of almost degenerate internal energy functions
    - the MakeThornList utility was updated to support more use cases
* important bugfixes
    - Carpet fix bug when using "along-z", "along-dir" and "manual" processor decomposition
    - AHFinderDirect has been fixed to avoid a long-standing issue where hte number of metric timelevels needed to be set to 3 to avoid errors during recovery from a checkpoint
    - the parameter file for the Kasner example in Class. Quantum Grav. 29 115001 (2012) was corrected to produce the results shown in the paper
* Cactus
    - Cactus documentation now contains information on the git revisions used to produce documentation
    - a long standing bug in `CCTK_TraverseString` when traversing "all" groups was fixed
    - the testsuite mechanism provides options to run only some tests
    - the testsuite mechanism will run all tests that request less than the available number of processes, running more tests
    - Cactus option lists can now refer to environment variables using `${ENV-VAR-NAME}`
    - cross compiling support in Cactus has been improved
    - Cactus now supports building on Raspberry Pi out of the box
* more thorn documentation available online
* machine defintion files were updated

## How to upgrade from Mayer (ET_2019_10)

To upgrade from the previous release, use GetComponents with the new thornlist to check out the new version.

See the Download page ([http://einsteintoolkit.org/download.html](http://einsteintoolkit.org/download.html)) on the Einstein Toolkit website for download instructions.

The SelfForce-1D code uses as single git repository, thus using `git pull ; git checkout ET_2020_05` will update the code.

## Machine notes

Supported (tested) machines include:

* Default Debian, Ubuntu, Fedora, CentOS 7, Mint, OpenSUSE and MacOS Mojave (MacPorts) installations
* Bluewaters
* Comet
* Cori
* Queen Bee 2
* Stampede 2
* Summit
* Mike / Shelob
* SuperMUC-NG
* Wheeler

* TACC machines: defs.local.ini needs to have `sourcebasedir = $WORK` and `basedir = $SCRATCH/simulations` configured for this machine. You need to determine `$WORK` and `$SCRATCH` by logging in to the machine.
* SuperMUC-NG: defs.local.ini needs to have `sourcebasedir = $HOME` and `basedir = $SCRATCH/simulations` configured for this machine. You need to determine `$HOME` and `$SCRATCH` by logging in to the machine.

All repositories participating in this release carry a branch ET_2020_05 marking this release. These release branches will be updated if severe errors are found.

The "Turing" Release Team on behalf of the Einstein Toolkit Consortium (2020-05-31)

* Roland Haas
* Brock Brendal
* Bill Gabella
* Beyhan Karakas
* Atul Kedia
* Shawn Rosofsky
* Steven R. Brandt
* Alois Peter Schaffarczyk

May, 2020
