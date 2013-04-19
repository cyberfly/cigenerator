cigenerator
===========

Code generator for CodeIgniter + Twitter Bootstrap + My Model

about cigenerator
=================

This Code Generator will generate basic CRUD (add, edit, delete, list) controller , model, view (add,edit form),
javascript, and also the lang file. The model is utilizing Jamie Rumbelow MY Model which you can get it from Github.

why cigenerator
===============================

There are many CRUD generator out there, but not much to my liking. So I build this one for my own daily use and tailored to my preference and practice when coding. However instead
just keep it to myself, I think maybe I can make it open source to improve it and also help others.

How to setup
============

1. Set your database connection at application/config/database.php
2. Change builds folder permission to 0777 if you are on unix platform (linux/mac)

How to use
==========

1. Choose table that you want to generate CRUD
2. Choose field that will appeared in form
3. Choose the form validation
4. Generate!

Database table convention
=========================

Table name example : tb_department, tb_position
PK field example : department_id, staff_id, position_id
FK example : department_id, staff_id, position_id

By using same field name, we can auto generate relationship between 2 tables

Sample database will be uploaded later.


