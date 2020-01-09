<?php


namespace App\Entity;


abstract class AbstractJournal
{
    abstract public function getUrl();

    abstract public function getTitle();

    abstract public function getPublisher();

    abstract public function getEISSN();

    abstract public function getISSN();

    abstract public function getRank();

    abstract public function getSubjectArea();
}
