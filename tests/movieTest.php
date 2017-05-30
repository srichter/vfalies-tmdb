<?php

namespace Vfac\Tmdb;

use PHPUnit\Framework\TestCase;

/**
 * @cover Movie
 */
class MovieTest extends TestCase
{

    protected $tmdb     = null;
    protected $movie    = null;
    protected $movie_id = 11;

    public function setUp()
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(Tmdb::class)
                ->setConstructorArgs(array('fake_api_key'))
                ->setMethods(['sendRequest', 'getConfiguration'])
                ->getMock();
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->tmdb = null;
    }

    private function setRequestOk()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/movieOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);
    }

    private function setRequestMovieEmpty()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/movieEmptyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);
    }

    private function setRequestConfigurationEmpty()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationEmptyOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/movieOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);
    }

    /**
     * @test
     */
    public function testGetAllGenres()
    {
        $json_object = json_decode(file_get_contents('tests/json/genresOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);
        $this->setRequestOk();

        $movie  = new Movie($this->tmdb, $this->movie_id);
        $genres = $movie->getAllGenres();

        $this->assertArrayHasKey(12, $genres); // 12 : Aventure
        $this->assertEquals('Aventure', $genres[12]);
        $this->assertArrayHasKey(10770, $genres); // 10770 : Téléfilm
        $this->assertEquals('Téléfilm', $genres[10770]);
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testContructFailure()
    {
        $this->tmdb->method('sendRequest')->will($this->throwException(new \Exception()));

        new Movie($this->tmdb, $this->movie_id);
    }

    /**
     * @test
     */
    public function testGetTitle()
    {
        $this->setRequestOk();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertEquals('La Guerre des étoiles', $movie->getTitle());
    }

    /**
     * @test
     */
    public function testGetTitleFailure()
    {
        $this->setRequestMovieEmpty();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertEmpty($movie->getTitle());
    }

    /**
     * @test
     */
    public function testGetGenres()
    {
        $this->setRequestOk();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertCount(3, $movie->getGenres());
    }

    /**
     * @test
     */
    public function testGetGenresFailure()
    {
        $this->setRequestMovieEmpty();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertEmpty($movie->getGenres());
    }

    /**
     * @test
     */
    public function testGetOverview()
    {
        $this->setRequestOk();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertInternalType('string', $movie->getOverview());
        $this->assertStringStartsWith('Il y a bien longtemps, dans une galaxie très lointaine...', $movie->getOverview());
    }

    /**
     * @test
     */
    public function testGetOverviewFailure()
    {
        $this->setRequestMovieEmpty();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertEmpty($movie->getOverview());
    }

    /**
     * @test
     */
    public function testGetReleaseDate()
    {
        $this->setRequestOk();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertEquals('1977-05-25', $movie->getReleaseDate());
    }

    /**
     * @test
     */
    public function testGetReleaseDateFailure()
    {
        $this->setRequestMovieEmpty();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertEmpty($movie->getReleaseDate());
    }

    /**
     * @test
     */
    public function testOriginalTitle()
    {
        $this->setRequestOk();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertEquals('Star Wars', $movie->getOriginalTitle());
    }

    /**
     * @test
     */
    public function testOriginalTitleFailure()
    {
        $this->setRequestMovieEmpty();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertEmpty($movie->getOriginalTitle());
    }

    /**
     * @test
     */
    public function testGetNote()
    {
        $this->setRequestOk();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertInternalType('double', $movie->getNote());
        $this->assertEquals('8', $movie->getNote());
    }

    /**
     * @test
     */
    public function testGetNoteFailure()
    {
        $this->setRequestMovieEmpty();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertEmpty($movie->getNote());
    }

    /**
     * @test
     */
    public function testGetIMDBId()
    {
        $this->setRequestOk();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertInternalType('string', $movie->getIMDBId());
        $this->assertEquals('tt0076759', $movie->getIMDBId());
    }

    /**
     * @test
     */
    public function testGetIMDBIdFailure()
    {
        $this->setRequestMovieEmpty();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertEmpty($movie->getIMDBId());
    }

    /**
     * @test
     */
    public function testGetTagline()
    {
        $this->setRequestOk();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertInternalType('string', $movie->getTagLine());
        $this->assertEquals('Il y a bien longtemps dans une galaxie très lointaine...', $movie->getTagLine());
    }

    /**
     * @test
     */
    public function testGetTaglineFailure()
    {
        $this->setRequestMovieEmpty();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertEmpty($movie->getTagLine());
    }

    /**
     * @test
     */
    public function testCollectionId()
    {
        $this->setRequestOk();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertInternalType('int', $movie->getCollectionId());
        $this->assertEquals('10', $movie->getCollectionId());
    }

    /**
     * @test
     */
    public function testCollectionIdFailure()
    {
        $this->setRequestMovieEmpty();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertEmpty($movie->getCollectionId());
    }

    /**
     * @test
     */
    public function testGetPoster()
    {
        $this->setRequestOk();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertNotFalse(filter_var($movie->getPoster(), FILTER_VALIDATE_URL));
    }

    /**
     * @test
     */
    public function testGetPosterFailure()
    {
        $this->setRequestMovieEmpty();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertEmpty($movie->getPoster());
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testGetPosterFailureConf()
    {
        $this->setRequestConfigurationEmpty();

        $movie = new Movie($this->tmdb, $this->movie_id);
        $movie->getPoster();
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testGetPosterFailureSize()
    {
        $this->setRequestOk();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $movie->getPoster('w184');
    }

    /**
     * @test
     */
    public function testGetBackdrop()
    {
        $this->setRequestOk();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertNotFalse(filter_var($movie->getBackdrop(), FILTER_VALIDATE_URL));
    }

    /**
     * @test
     */
    public function testGetBackdropFailure()
    {
        $this->setRequestMovieEmpty();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $this->assertEmpty($movie->getBackdrop());
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testGetBackdropFailureConf()
    {
        $this->setRequestConfigurationEmpty();

        $movie = new Movie($this->tmdb, $this->movie_id);
        $movie->getBackdrop();
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testGetBackdropFailureSize()
    {
        $this->setRequestOk();

        $movie = new Movie($this->tmdb, $this->movie_id);

        $movie->getBackdrop('w184');
    }
}