<?php

namespace vfalies\tmdb\Items;

use PHPUnit\Framework\TestCase;

/**
 * @cover Company
 */
class CompanyTest extends TestCase
{

    protected $tmdb     = null;
    protected $company    = null;
    protected $company_id = 11;

    public function setUp()
    {
        parent::setUp();

        $this->tmdb = $this->getMockBuilder(\vfalies\tmdb\Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')])))
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

        $json_object = json_decode(file_get_contents('tests/json/companyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);
    }

    private function setRequestCompanyEmpty()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/companyEmptyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);
    }

    private function setRequestConfigurationEmpty()
    {
        $json_object = json_decode(file_get_contents('tests/json/configurationEmptyOk.json'));
        $this->tmdb->method('getConfiguration')->willReturn($json_object);

        $json_object = json_decode(file_get_contents('tests/json/companyOk.json'));
        $this->tmdb->method('sendRequest')->willReturn($json_object);
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testContructFailure()
    {
        $this->tmdb->method('sendRequest')->will($this->throwException(new \Exception()));

        new Company($this->tmdb, $this->company_id);
    }

    /**
     * @test
     */
    public function testGetName()
    {
        $this->setRequestOk();

        $company = new Company($this->tmdb, $this->company_id);

        $this->assertEquals('Lucasfilm', $company->getName());
    }

    /**
     * @test
     */
    public function testGetNameFailure()
    {
        $this->setRequestCompanyEmpty();

        $company = new Company($this->tmdb, $this->company_id);

        $this->assertEmpty($company->getName());
    }

    /**
     * @test
     */
    public function testGetDescription()
    {
        $this->setRequestOk();

        $company = new Company($this->tmdb, $this->company_id);

        $this->assertEquals('A Georges Lucas company', $company->getDescription());
    }

    /**
     * @test
     */
    public function testGetDescriptionFailure()
    {
        $this->setRequestCompanyEmpty();

        $company = new Company($this->tmdb, $this->company_id);

        $this->assertEmpty($company->getDescription());
    }

    /**
     * @test
     */
    public function testGetHeadquarters()
    {
        $this->setRequestOk();

        $company = new Company($this->tmdb, $this->company_id);

        $this->assertEquals('San Francisco, California', $company->getHeadQuarters());
    }

    /**
     * @test
     */
    public function testGetHeadQuartersFailure()
    {
        $this->setRequestCompanyEmpty();

        $company = new Company($this->tmdb, $this->company_id);

        $this->assertEmpty($company->getHeadQuarters());
    }

    /**
     * @test
     */
    public function testGetHomepage()
    {
        $this->setRequestOk();

        $company = new Company($this->tmdb, $this->company_id);

        $this->assertEquals('http://www.lucasfilm.com', $company->getHomePage());
    }

    /**
     * @test
     */
    public function testGetHomepageFailure()
    {
        $this->setRequestCompanyEmpty();

        $company = new Company($this->tmdb, $this->company_id);

        $this->assertEmpty($company->getHomePage());
    }

    /**
     * @test
     */
    public function testGetId()
    {
        $this->setRequestOk();

        $company = new Company($this->tmdb, $this->company_id);

        $this->assertEquals(1, $company->getId());
    }

    /**
     * @test
     */
    public function testGetIdFailure()
    {
        $this->setRequestCompanyEmpty();

        $company = new Company($this->tmdb, $this->company_id);

        $this->assertEquals(0, $company->getId());
    }

   /**
     * @test
     */
    public function testGetLogoPath()
    {
        $this->setRequestOk();

        $company = new Company($this->tmdb, $this->company_id);
        $this->assertInternalType('string', $company->getLogoPath());
        $this->assertNotEmpty($company->getLogoPath());
    }

    /**
     * @test
     */
    public function testGetLogoPathFailure()
    {
        $this->setRequestCompanyEmpty();
        $company = new Company($this->tmdb, $this->company_id);
        $this->assertInternalType('string', $company->getLogoPath());
        $this->assertEmpty($company->getLogoPath());
    }

}
