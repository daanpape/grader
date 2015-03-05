In this document the assessment tool grading engine is explained. 


1. Assessment rules
-------------------

While giving points is important, there are also assessment rules. 
These are user controllable boolean operators which make decisions
on an objective manner.

The structure of a rule is as follows:
 
-------------------------------------------------
| SYSTEM_VALUE | OPERATOR | USER_VALUE | ACTION |
-------------------------------------------------
 
 Some more detailed explenation:
  - SYSTEM_VALUE: in a project there are many variables such as
                  documents, points, users, ... all these variables
                  are kept en set by the system. They are the base
                  on which you can apply rules.
 
  - OPERATOR: the operator can be (<, <=, ==, >=, >=) or anything
              else that compares two values with a booelan outcome.
 
 - USER_VALUE: this is a value the user can set, it will have a
               large impact on the outcome of the rule comparison.
 
 - ACTION: the action to take after evaluating the rule. This is
           a user function called with the result of the rule. 
