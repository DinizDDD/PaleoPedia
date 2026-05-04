DROP DATABASE paleo_db;

CREATE DATABASE paleo_db;

USE paleo_db;

CREATE TABLE tax (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
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
    FOREIGN KEY (parent_id) REFERENCES tax(id)
);

CREATE TABLE images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    _path VARCHAR(150),
    legenda TEXT
);

CREATE TABLE geo_time (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    tipo ENUM(
        'era',
        'periodo',
        'epoca',
        'idade'
    ),
    begin_year DECIMAL(8,2),
    end_year DECIMAL(8,2),
    parent_id INT,
    FOREIGN KEY (parent_id) REFERENCES geo_time(id)
);

CREATE TABLE geotime_images (
    geotime_id INT,
    image_id INT,
    PRIMARY KEY (geotime_id_id, image_id),
    FOREIGN KEY (geotime_id_id) REFERENCES geo_time(id),
    FOREIGN KEY (image_id) REFERENCES images(id)

)

CREATE TABLE species (
    id INT AUTO_INCREMENT PRIMARY KEY,
    taxon_id INT,
    cientific_name VARCHAR(150) UNIQUE,
    nome VARCHAR(150),
    autor VARCHAR(150),
    descricao TEXT,
    diet ENUM(
        'carnivore',
        'herbivore',
        'omnivorous'
    ),
    comprimento DECIMAL(6,2),
    peso INT,
    discovery_year INT,
    discovery_local VARCHAR(150),
    image_id INT,
    geotime_id INT,

    FOREIGN KEY (taxon_id) REFERENCES tax(id),
    FOREIGN KEY (image_id) REFERENCES images(id),
    FOREIGN KEY (geotime_id) REFERENCES geo_time(id)
);

CREATE TABLE species_images (
    species_id INT,
    image_id INT,
    PRIMARY KEY (species_id, image_id),
    FOREIGN KEY (species_id) REFERENCES species(id),
    FOREIGN KEY (image_id) REFERENCES images(id)
);