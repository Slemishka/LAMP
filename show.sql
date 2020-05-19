/*    ID: show.sql
    Purpose: sql file for getting entire data from database tables
    Created by: Alisher Maratov*/


show databases;
use MicrowaveRadioSystem;
show tables;
show columns from End_Point;
show columns from Path_Info;
show columns from PhysicalFactors;
select * from Path_Info;
select * from End_Point;
select * from PhysicalFactors;