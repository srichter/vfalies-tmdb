<?php

namespace vfalies\tmdb\Interfaces\Items;

interface TVSeasonInterface
{
    public function getId(): int;

    public function getPosterPath() : string;

    public function getEpisodeCount() : int;

    public function getEpisodes() : \Generator;

    public function getAirDate() : string;

    public function getSeasonNumber() : int;

    public function getName() : string;

    public function getOverview() : string;
}