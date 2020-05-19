
    DROP DATABASE IF EXISTS MicrowaveRadioSystem;
    CREATE DATABASE IF NOT EXISTS MicrowaveRadioSystem CHARACTER SET utf8;

    DROP USER IF EXISTS 'group12'@'localhost';
    CREATE USER 'group12'@'localhost' IDENTIFIED BY 'yelemeno';
    GRANT ALL PRIVILEGES ON MicrowaveRadioSystem.* TO 'group12'@'localhost';


    USE MicrowaveRadioSystem;

    CREATE TABLE  IF NOT EXISTS Path_Info
    (
            path_id int NOT NULL AUTO_INCREMENT,
            path_name VARCHAR(100) NOT NULL,
            operating_frequency FLOAT NOT NULL,
            Description VARCHAR(255) NOT NULL,
            Note TEXT NOT NULL,
            filePath VARCHAR(100) NOT NULL,
            PRIMARY KEY (path_id)
        );

      CREATE TABLE  IF NOT EXISTS End_Point
         (
             end_point_id INT NOT NULL
             AUTO_INCREMENT,
             end_point_path_id int NOT NULL,
             distance_from_start FLOAT NOT NULL,
             ground_height FLOAT NOT NULL,
             antenna_height FLOAT NOT NULL,
             antenna_cable_type TEXT NOT NULL,
             antenna_cable_length FLOAT NOT NULL ,
             PRIMARY KEY (end_point_id),
             CONSTRAINT fk_Path_Info FOREIGN KEY (end_point_path_id)
             REFERENCES Path_Info(path_id)
         );


        CREATE TABLE IF NOT EXISTS  PhysicalFactors
        (
            physical_factor_id int(11) NOT NULL AUTO_INCREMENT,
            pf_path_id int NOT NULL ,
            distance_from_start FLOAT NOT NULL,
            Ground_Height FLOAT NOT NULL,
            Terrain_Type  VARCHAR (50)  NOT NULL,
            Obstruction_Height FLOAT NOT NULL,
            Obstruction_Type VARCHAR(50) NOT NULL,
            PRIMARY KEY (physical_factor_id),
            CONSTRAINT fk_pf_Path_Info FOREIGN KEY (pf_path_id)
            REFERENCES Path_Info(path_id)
        );


        -- INSERT INTO End_Point
        -- VALUES
        --  (1, 1.2, 25, 14, 'LDF4-50A', 2.3);
        -- insert into End_Point values (1,2.5,5,6,'LDF4-50A