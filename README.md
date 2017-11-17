# idarwincore
IDarwinCore is an online database package which allows 
the display of a natural history collection's data
in a very organic way.  The data can be queried via 
a variety of fields such as genus/species/state/province/county/
collector/collection number/catalog number/accession number, etc.
Also county level distribution maps can now be generated on the fly from
specimen occurrence data.

This database package is also extremely useful in diagnosing issues with
Symbiota databases.  Simply export the Symbiota data to DwC-A format, and
then import that data into iDarwinCore where you can view the number of records
with unique barcodes, unique image links, and records with invalid
barcodes.  iDarwinCore makes it easy to detect issues in your data, such as,
duplicate id's, duplicate image links, multiple images associated with 
a single occurrence record, and invalid barcodes.  Most of these
issues are difficult if not impossible to diagnose within Symbiota.

This database package makes it easy to import data from a wide
variety of resources due to it's support of the DWC-A (Darwin
Core Archive) a standardized archive widely used by natural history
collectors world wide.

For more information about DWC-A format see
https://en.wikipedia.org/wiki/Darwin_Core_Archive
