<?php

namespace vfalies\tmdb\Results;

use vfalies\tmdb\Abstracts\Results;
use vfalies\tmdb\Tmdb;
use vfalies\tmdb\Interfaces\Results\TVShowResultsInterface;
use vfalies\tmdb\Traits\ElementTrait;

class TVShow extends Results implements TVShowResultsInterface
{
    use ElementTrait;

    protected $overview       = null;
    protected $first_air_date = null;
    protected $original_name  = null;
    protected $name           = null;
    protected $backdrop_path  = null;
    protected $poster_path    = null;

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     * @param \stdClass $result
     */
    public function __construct(Tmdb $tmdb, \stdClass $result)
    {
        parent::__construct($tmdb, $result);

        // Populate data
        $this->id             = $this->data->id;
        $this->overview       = $this->data->overview;
        $this->first_air_date = $this->data->first_air_date;
        $this->original_name  = $this->data->original_name;
        $this->name           = $this->data->name;
        $this->poster_path    = $this->data->poster_path;
        $this->backdrop_path  = $this->data->backdrop_path;
    }

    /**
     * Get tvshow ID
     * @return int
     */
    public function getId()
    {
        return (int) $this->id;
    }

    /**
     * Get tvshow overview
     * @return string
     */
    public function getOverview()
    {
        return $this->overview;
    }

    /**
     * Get tvshow first air date
     * @return string
     */
    public function getReleaseDate()
    {
        return $this->first_air_date;
    }

    /**
     * Get tvshow original name
     * @return string
     */
    public function getOriginalTitle()
    {
        return $this->original_name;
    }

    /**
     * Get tvshow name
     * @return string
     */
    public function getTitle()
    {
        return $this->name;
    }
}
