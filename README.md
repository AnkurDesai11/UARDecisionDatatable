# UARDecisionDatatable
PHP JS webportal for user access review

#### Introduction
This web application is a simple interface to allow users to enter inputs for every row of data presented to them. This application was designed to eliminate manual review collection thorugh email or shared documents and allow managers to input review decisions for the user accounts of their team members through a unified web portal.
This process eliminates the end users manipulating key aspects of data while sharing their decisions (sharing decisions in a file format different from the one shared or modifying data which entering their decisions)

#### Working
The application checks the database for any rows with the current logged in user as the manager and displays those rows for review decision. Managers can update previosly entered decisions if required.

#### Misc
This application can be deployed using MAMP/XAMMP stack and requires a MySQL database for storing data. The table element containing the data is rendered using the tabulator library.
This application should be integrated with the enterprise identity solution to allow for SSO for manager rather than providing separate appliation provided credentials (todo).
