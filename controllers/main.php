<?php

include_once('controllers/datas.php');
include_once('models/model.php');
include_once('models/films.php');
include_once('models/people.php');
include_once('models/planets.php');
include_once('models/species.php');
include_once('models/transport.php');
include_once('models/vehicles.php');

class Main {

    public $films = [];
    public $peoples = [];
    public $planets = [];
    public $species = [];
    public $starships = [];
    public $vehicles = [];

    public function __construct() {
        $this->datas = new Data();
        $this->run();
        $this->manageRelations();
    }

    public function start() {
        echo($this->films[0]);
        echo($this->peoples[0]);
        echo($this->planets[0]);
        echo($this->species[0]);
        echo($this->starships[0]);
        echo($this->vehicles[0]);
    }

    private function run() {
        $this->runFilms();
        $this->runPlanets();
        $this->runPeoples();
        $this->runSpecies();
        $this->runStarships();
        $this->runVehicles();
    }

    private function runFilms() {
        $films_datas = $this->datas->getData("films");
        foreach ($films_datas as $film_datas) {
            $this->runFilm($film_datas);
        }
    }

    private function runFilm($film_datas) {
        $this->films[] = new Film($film_datas);
    }

    private function runPlanets() {
        $planets_datas = $this->datas->getData("planets");
        foreach ($planets_datas as $planet_datas) {
            $this->runPlanet($planet_datas);
        }
    }

    private function runPlanet($planet_datas) {
        $this->planets[] = new Planet($planet_datas);
    }

    private function runPeoples() {
        $peoples_datas = $this->datas->getData("people");
        foreach ($peoples_datas as $people_datas) {
            $this->runPeople($people_datas);
        }
    }

    private function runPeople($people_datas) {
        $this->peoples[] = new People($people_datas);
    }

    private function runSpecies() {
        $species_datas = $this->datas->getData("species");
        foreach ($species_datas as $specie_datas) {
            $this->runSpecie($specie_datas);
        }
    }

    private function runSpecie($specie_datas) {
        $this->species[] = new Specie($specie_datas);
    }

    private function runStarships() {
        $starships_datas = $this->datas->getData("transport");
        foreach ($starships_datas as $starship_datas) {
            $this->runStarship($starship_datas);
        }
    }

    private function runStarship($starship_datas) {
        $this->starships[] = new Transport($starship_datas);
    }

    private function runVehicles() {
        $vehicles_datas = $this->datas->getData("vehicles");
        foreach ($vehicles_datas as $vehicle_datas) {
            $this->runVehicle($vehicle_datas);
        }
    }

    private function runVehicle($vehicle_datas) {
        $this->vehicles[] = new Vehicle($vehicle_datas);
    }

    private function manageRelations() {
        $this->manageFilmsRelations();
        $this->manageSpeciesRelations();
        $this->managePeoplesRelations();
    }

    private function manageFilmsRelations() {
        foreach ($this->films as $film) {
            $this->makeStarshipsRelations($film);
            $this->makeCharactersRelations($film);
            $this->makeSpeciesRelations($film);
            $this->makeVehiclesRelations($film);
            $this->makePlanetsRelations($film);
        }
    }

    private function manageSpeciesRelations() {
        foreach ($this->species as $specie) {
            $this->makePeoplesRelations($specie);
            $this->makeHomeworldRelation($specie);
        }
    }

    private function managePeoplesRelations() {
        foreach ($this->peoples as $people) {
            $this->makeHomeworldRelation($people);
        }
    }

    private function makeHomeworldRelation($model) {
        $planet = $this->getPlanetById($model->homeworld);
        if ($planet) {
            $model->homeworld = $planet;
        }
    }

    private function makeStarshipsRelations($film) {
        foreach ($film->starships as $key => $value) {
            $starship = $this->getStarshipById($value);
            if ($starship) {
                $film->starships[$key] = $starship;
            }
        }
    }

    private function makeCharactersRelations($film) {
        foreach ($film->characters as $key => $value) {
            $people = $this->getPeopleById($value);
            if ($people) {
                $film->characters[$key] = $people;
            }
        }
    }
    
    private function makePeoplesRelations($film) {
        foreach ($film->people as $key => $value) {
            $people = $this->getPeopleById($value);
            if ($people) {
                $film->people[$key] = $people;
            }
        }
    }

    private function makeSpeciesRelations($film) {
        foreach ($film->species as $key => $value) {
            $specie = $this->getSpecieById($value);
            if ($specie) {
                $film->species[$key] = $specie;
            }
        } 
    }

    private function makeVehiclesRelations($film) {
        foreach ($film->vehicles as $key => $value) {
            $vehicle = $this->getVehicleById($value);
            if ($vehicle) {
                $film->vehicles[$key] = $vehicle;
            }
        }
    }

    private function makePlanetsRelations($film) {
        foreach ($film->planets as $key => $value) {
            $planet = $this->getPlanetById($value);
            if ($planet) {
                $film->planets[$key] = $planet;
            }
        }
    }

    private function getFilmById($id) {
        foreach ($this->films as $film) {
            if ($film->id == $id) {
                return $film;
            }
        }
        return false;
    }

    private function getPeopleById($id) {
        foreach ($this->peoples as $people) {
            if ($people->id == $id) {
                return $people;
            }
        }
        return false;
    }
    
    private function getPlanetById($id) {
        foreach ($this->planets as $planet) {
            if ($planet->id == $id) {
                return $planet;
            }
        }
        return false;
    }

    private function getSpecieById($id) {
        foreach ($this->species as $specie) {
            if ($specie->id == $id) {
                return $specie;
            }
        }
        return false;
    }

    private function getStarshipById($id) {
        foreach ($this->starships as $starship) {
            if ($starship->id == $id) {
                return $starship;
            }
        }
        return false;
    }

    private function getVehicleById($id) {
        foreach ($this->vehicles as $vehicle) {
            if ($vehicle->id == $id) {
                return $vehicle;
            }
        }
        return false;
    }
}

?>