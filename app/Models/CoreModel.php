<?php

namespace App\Models;

// Classe mère de tous les Models
// On centralise ici toutes les propriétés et méthodes utiles pour TOUS les Models
// La classe est définie comme abstract => il est INTERDIT de l'instancier sinon fatal error
abstract class CoreModel
{

    // J'indique que toute classe qui hérite de CoreModel DOIT IMPERATIVEMENT
    // implémenter une méthode find qui doit etre statique
    // Attention, elle n'oblige rien au niveau du CONTENU de la méthode

    // abstract static function find( $id );
    // abstract static function findAll();
    // abstract static function insert();
    // abstract static function update();
    // abstract static function delete();


    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $created_at;
    /**
     * @var string
     */
    protected $updated_at;


    /**
     * Get the value of id
     *
     * @return  int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of created_at
     *
     * @return  string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * Get the value of updated_at
     *
     * @return  string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }
}