<?php

namespace vfalies\tmdb\Abstracts;

use vfalies\tmdb\Tmdb;
use vfalies\tmdb\Exceptions\NotFoundException;
use vfalies\tmdb\Interfaces\Results\ResultsInterface;

abstract class Results extends Element implements ResultsInterface
{

    protected $id                 = null;
    protected $property_blacklist = ['property_blacklist', 'conf', 'data', 'logger'];
    protected $logger             = null;

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     * @param \stdClass $result
     * @throws NotFoundException
     */
    public function __construct(Tmdb $tmdb, \stdClass $result)
    {
        $this->logger = $tmdb->logger;
        
        // Valid input object
        $properties   = get_object_vars($this);
        foreach (array_keys($properties) as $property) {
            if (!in_array($property, $this->property_blacklist) && !property_exists($result, $property)) {
                throw new NotFoundException($property);
            }
        }

        // Configuration
        $this->conf = $tmdb->getConfiguration();
        $this->data = $result;
    }
}