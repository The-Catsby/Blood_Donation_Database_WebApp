# CS-340_DatabaseApp

### CS 340 Project

### Overview

You will be making a database driven website using HTML, PHP and MySQL. HTML is a markup
language used for laying out your website. You may work in pairs. PHP is a server side scripting language
allowing content to be generated when the page is loaded. PHP will use a MySQL database to store the
information that is used to populate fields on the website. Your database should have at least 4 entities
and at least 4 relationships, one of which must be a many to many relationship. It should be possible to
add entries to every table (although it is fine to have tables prepopulated with data) and every table
should be used in at least one select query. If you have complex SELECT queries that feature things
like NOT IN, aggregate functions then you don't need the deletes and updates.

### The pieces

### Outline (5%)

Give me a paragraph or two explaining your database content. If it is about auto dealerships, tell me
what goes on at the auto dealership and why it would be interesting to track that data.

### Database Outline in Words (5%)

Tell me how the data is supposed to work. This is similar to the description I gave for the question 3 of
assignment 1. What constraints should be in place. What tables are related to what other tables. A lot of
the grading will be based on if things match this description of your database so make sure it is
complete. If you say a constraint exist and you don’t enforce it, that is incorrect. If you enforce a
constraint you don’t describe, that is incorrect.

### ER Diagram of Database (10%)

This diagram should capture, as best as possible, all of the constraints and components of your database
outline.

### Database Schema (10%)

This should capture every attribute of every table. Additionally it should show every foreign key
reference used in the database.

### Table Creation Queries (10%)

I want to see the queries your ran to build your tables. These should not be in any of the website code
because you should not be dynamically building or deleting tables.

### General Use Queries (30%)

I want to see all of the queries that will be used to select, update, add or delete data. Because many of
these will be based on user input, use square brackets to act as place holders for variables that will be
user provided. For example, if I were going to query based on employee salaries, I might have a query
like this:
SELECT salary FROM employee WHERE salary > [salaryInput ];
Another example
INSERT INTO employee(name, age) VALUES ([user],[name]);

### HTML (10%)

All of the needed forms and buttons should be present to allow me to perform all of actions required of
the database. This is graded on if the functionality is there. Not if it looks pretty.

### PHP (10%)

You should be using the mysqli class to perform your database operations. It should be clear what all the
code is doing. It should produce no errors.

### Style (10%)

This is a catchall for if you have bad coding style, don’t comment, have illegible diagrams etc.
