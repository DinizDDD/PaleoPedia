DROP DATABASE IF EXISTS paleo_db;

CREATE DATABASE paleo_db;

USE paleo_db;

CREATE TABLE tax (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    slug VARCHAR(150) UNIQUE,
    rank ENUM(
        'reino',
        'filo',
        'classe',
        'ordem',
        'familia',
        'genero'
    ),
    parent_id INT,
    descricao TEXT,
    FOREIGN KEY (parent_id) REFERENCES tax(id) ON DELETE CASCADE
);

CREATE TABLE images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    _path VARCHAR(255),
    legenda TEXT
);

CREATE TABLE geo_time (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(150) UNIQUE,
    name VARCHAR(100),
    type ENUM(
        'era',
        'periodo',
        'epoca',
        'idade'
    ),
    begin_year DECIMAL(8,2),
    end_year DECIMAL(8,2),
    parent_id INT,
    FOREIGN KEY (parent_id) REFERENCES geo_time(id) ON DELETE CASCADE
);

CREATE TABLE geotime_images (
    geotime_id INT,
    image_id INT,
    PRIMARY KEY (geotime_id, image_id),
    FOREIGN KEY (geotime_id) REFERENCES geo_time(id) ON DELETE CASCADE,
    FOREIGN KEY (image_id) REFERENCES images(id) ON DELETE CASCADE
);

CREATE TABLE species (
    id INT AUTO_INCREMENT PRIMARY KEY,
    taxon_id INT,
    scientific_name VARCHAR(150) UNIQUE,
    name VARCHAR(150),
    slug VARCHAR(150) UNIQUE,
    summary TEXT,
    diet ENUM(
        'carnivoro',
        'herbivoro',
        'onivoro',
        'piscivoro',
        'insetivoro'
    ),
    length DECIMAL(6,2),
    height DECIMAL(6,2),
    weight INT,
    behavior TEXT,
    ecology TEXT,
    curiosities TEXT,
    discovery_year INT,
    discovery_local VARCHAR(150),
    formation VARCHAR(150),
    discovered_by VARCHAR(150),
    habitat VARCHAR(150),
    region VARCHAR(150),
    biome VARCHAR(150),
    climate VARCHAR(150),
    continent VARCHAR(150),
    image_id INT,
    geotime_id INT,
    FOREIGN KEY (taxon_id) REFERENCES tax(id) ON DELETE CASCADE,
    FOREIGN KEY (image_id) REFERENCES images(id) ON DELETE CASCADE,
    FOREIGN KEY (geotime_id) REFERENCES geo_time(id) ON DELETE CASCADE
);

CREATE TABLE species_images (
    species_id INT,
    image_id INT,
    PRIMARY KEY (species_id, image_id),
    FOREIGN KEY (species_id) REFERENCES species(id) ON DELETE CASCADE,
    FOREIGN KEY (image_id) REFERENCES images(id) ON DELETE CASCADE
);

CREATE TABLE species_relations (
    species_id INT,
    related_species_id INT,
    relation_type ENUM('coexistiu'),
    PRIMARY KEY (species_id, related_species_id),
    FOREIGN KEY (species_id) REFERENCES species(id) ON DELETE CASCADE,
    FOREIGN KEY (related_species_id) REFERENCES species(id) ON DELETE CASCADE
);