# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased](https://github.com/KongHack/FormConfig/commits/master)



## [3.0.12](https://github.com/KongHack/FormConfig/releases/tag/3.0.12)
 - @GameCharmer Only run select2 ajax auto-pass on primitives


## [3.0.11](https://github.com/KongHack/FormConfig/releases/tag/3.0.11)
 - @GameCharmer Automatically grab any data points on select2 ajax fields and auto-pass


## [3.0.10](https://github.com/KongHack/FormConfig/releases/tag/3.0.10)
 - @GameCharmer Allow array elements to contain array elements. 
     You can totally create an infinitely recursive mess with this, so be careful.


## [3.0.9](https://github.com/KongHack/FormConfig/releases/tag/3.0.9)
 - @GameCharmer Merge Ionic Again



## [3.0.8](https://github.com/KongHack/FormConfig/releases/tag/3.0.8)
 - @GameCharmer Add replace for namespaces to internal includes



## [3.0.7.1](https://github.com/KongHack/FormConfig/releases/tag/3.0.7.1)
 - @GameCharmer Fix typo in controller_block.twig



## [3.0.7](https://github.com/KongHack/FormConfig/releases/tag/3.0.7)
 - @GameCharmer Merge in Ionic branch



## [3.0.6](https://github.com/KongHack/FormConfig/releases/tag/3.0.6)
 - @GameCharmer replace append twig/html with new hook system 



## [3.0.5](https://github.com/KongHack/FormConfig/releases/tag/3.0.5)
 - @GameCharmer fix bug in form mode config loading


## [3.0.4](https://github.com/KongHack/FormConfig/releases/tag/3.0.4)
 - @GameCharmer New system for form config element types


## [3.0.3](https://github.com/KongHack/FormConfig/releases/tag/3.0.3)
 - @GameCharmer Swap the twig macro's replace to key on only REPLACE instead of `@form_config_REPLACE` 



## [3.0.2](https://github.com/KongHack/FormConfig/releases/tag/3.0.2)
 - @GameCharmer The builder now uses the standard FormField for field generation, but says it returns a particular object to assist with intellisense 



## [3.0.1](https://github.com/KongHack/FormConfig/releases/tag/3.0.1)
 - @GameCharmer Patch delete button form override



## [3.0.0](https://github.com/KongHack/FormConfig/releases/tag/3.0.0)
 - @GameCharmer Mode system to allow switching banks of twig files



## [2.1.8](https://github.com/KongHack/FormConfig/releases/tag/2.1.8)
 - @GameCharmer Updated composer.json to handle newer KInt



## [2.1.7](https://github.com/KongHack/FormConfig/releases/tag/2.1.7)
 - @GameCharmer Revert some H4s to DIVs where appropriate



## [2.1.6](https://github.com/KongHack/FormConfig/releases/tag/2.1.6)
 - @GameCharmer added a span around the "* = required" text to assist with additional styling



## [2.1.5](https://github.com/KongHack/FormConfig/releases/tag/2.1.5)
 - @GameCharmer add getReqLevel method to FormArrayElement



## [2.1.4](https://github.com/KongHack/FormConfig/releases/tag/2.1.4) *DNU*
 - @GameCharmer Patched missing FormConfig in FormArray



## [2.1.3](https://github.com/KongHack/FormConfig/releases/tag/2.1.3) *DNU*
 - @GameCharmer Moved required indicator to the left of help text
 - @GameCharmer Added FC_* helper classes for indicators/text



## [2.1.2](https://github.com/KongHack/FormConfig/releases/tag/2.1.2) *DNU*
 - @GameCharmer New Required Indicator and system for managing them



## [2.1.1](https://github.com/KongHack/FormConfig/releases/tag/2.1.1)
 - @jakerarr Fix for ternaries in the aria-labelledby attribute



## [2.1.0](https://github.com/KongHack/FormConfig/releases/tag/2.1.0) *DNU*
 - @jakerarr Updated radio-type/scale-type with WCAG compliant labeling
 - @jakerarr Table style update- adds IDs to TH's and aria-labelledby attributes to fields
 - @jakerarr Table style update- set default table ID for FormArrayElements if one is not set



## [2.0.9](https://github.com/KongHack/FormConfig/releases/tag/2.0.9)
 - @GameCharmer Implement Twig & HTML Append methods in output
 - @GameCharmer New Twig Object, `FC_Config`


## [2.0.8](https://github.com/KongHack/FormConfig/releases/tag/2.0.8)
 - @GameCharmer Added Twig & Html Append methods to form config
 - @GameCharmer Added key based IDs to each navigational button


## [2.0.7](https://github.com/KongHack/FormConfig/releases/tag/2.0.7)
 - @GameCharmer Caps in Likert Scale Twig


## [2.0.6](https://github.com/KongHack/FormConfig/releases/tag/2.0.6)
 - @GameCharmer convert config pathing to relative


## [2.0.5](https://github.com/KongHack/FormConfig/releases/tag/2.0.5)
 - @GameCharmer addBreak, addHR, repeatHeaders functions for arrays


## [2.0.4](https://github.com/KongHack/FormConfig/releases/tag/2.0.4)
 - @GameCharmer Resolve issue with both hold on and delete form


## [2.0.3](https://github.com/KongHack/FormConfig/releases/tag/2.0.3)
 - @GameCharmer Fix issue with spaces in data attribute values


## [2.0.2](https://github.com/KongHack/FormConfig/releases/tag/2.0.2)
 - @GameCharmer Fix form controller formId in JS


## [2.0.1](https://github.com/KongHack/FormConfig/releases/tag/2.0.1)
 - @GameCharmer Attempting to make `makeReadOnly` more reliable
 

## [2.0.0](https://github.com/KongHack/FormConfig/releases/tag/2.0.0)
 - @GameCharmer Upgraded to YML for configs
 - @GameCharmer added options for using HoldOn within your forms


## [1.4.3](https://github.com/KongHack/FormConfig/releases/tag/1.4.3)
 - @GameCharmer Resolve issue with multi-select via builder system


## [1.4.2](https://github.com/KongHack/FormConfig/releases/tag/1.4.2)
 - @GameCharmer Row class management for array elements


## [1.4.1](https://github.com/KongHack/FormConfig/releases/tag/1.4.1)
 - @GameCharmer New fluent methods for easier form config rendering


## [1.4.0](https://github.com/KongHack/FormConfig/releases/tag/1.4.0)
 - @GameCharmer New Simple Form System! Omit ``setTwigTemplate`` to generate a simple form with all fields as a list, even field arrays!
 - @GameCharmer No need to import the field array separately anymore. ``completeField`` handles those as well!


## [1.3.8](https://github.com/KongHack/FormConfig/releases/tag/1.3.8)
 - @GameCharmer Add class to true/false toggles
 
 
## [1.3.7](https://github.com/KongHack/FormConfig/releases/tag/1.3.7)
 - @GameCharmer throw an unbind in the delete hook


## [1.3.6](https://github.com/KongHack/FormConfig/releases/tag/1.3.6)
 - @GameCharmer Wasn't using the DocBlock library anywhere, so removed it


## [1.3.5](https://github.com/KongHack/FormConfig/releases/tag/1.3.5)
 - @GameCharmer Update DocBlock Library


## [1.3.4](https://github.com/KongHack/FormConfig/releases/tag/1.3.4)
 - @GameCharmer Update Composer License Field


## [1.3.3](https://github.com/KongHack/FormConfig/releases/tag/1.3.3)
 - @GameCharmer Added missing IDs, cleanup twig files


## [1.3.2](https://github.com/KongHack/FormConfig/releases/tag/1.3.2)
 - @GameCharmer Added for on labels, adjusted radio input


## [1.3.1](https://github.com/KongHack/FormConfig/releases/tag/1.3.1)
 - @GameCharmer fix for file input multi


## [1.3.0](https://github.com/KongHack/FormConfig/releases/tag/1.3.0)
 - @GameCharmer !!CAUTION!! May not be backwards compatible if you're not using the builder
 - NEW: Get field function
 - NEW: Make Read-Only system (per field)
 - NEW: MultiSelectInterface for identifying fields that need [] in the name 
 - FIX: potential recursive issue


## [1.2.5](https://github.com/KongHack/FormConfig/releases/tag/1.2.5)
 - @GameCharmer new global class, overflow auto on well


## [1.2.4](https://github.com/KongHack/FormConfig/releases/tag/1.2.4)
 - @GameCharmer fix assignment issue in password js


## [1.2.3](https://github.com/KongHack/FormConfig/releases/tag/1.2.3)
 - @GameCharmer raw on data attributes string


## [1.2.2](https://github.com/KongHack/FormConfig/releases/tag/1.2.2)
 - @GameCharmer OMFG, didn't know interface_exists was a thing


## [1.2.1](https://github.com/KongHack/FormConfig/releases/tag/1.2.1)
 - @GameCharmer major bug fix


## [1.2.0](https://github.com/KongHack/FormConfig/releases/tag/1.2.0)
 - @GameCharmer Field Builder System
 

## [1.1.1](https://github.com/KongHack/FormConfig/releases/tag/1.1.1)
 - @GameCharmer Fix for reqLevel


## [1.1.0](https://github.com/KongHack/FormConfig/releases/tag/1.1.0)
 - @GameCharmer Functioning System
 

### [1.0.0](https://github.com/KongHack/FormConfig/releases/tag/1.0.0)
Initial Commit