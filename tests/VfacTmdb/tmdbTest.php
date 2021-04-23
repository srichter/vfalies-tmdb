<?php

namespace VfacTmdb;

use PHPUnit\Framework\TestCase;
use VfacTmdb\Exceptions\TmdbException;
use VfacTmdb\Exceptions\IncorrectParamException;
use VfacTmdb\lib\Guzzle\Client as HttpClient;

class TmdbTest extends TestCase
{
    public function testCheckOptionYear()
    {
        $tmdb = new Tmdb('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client()));

        $options['year'] = 2017;
        $result          = [];
        $tmdb->checkOptionYear($options, $result);

        $this->assertEquals(2017, $result['year']);
    }

    public function testCheckOptionLanguageIncorrect()
    {
        $this->expectException(\VfacTmdb\Exceptions\IncorrectParamException::class);
        $tmdb = new Tmdb('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client()));

        $options['language'] = 'not_good_language';
        $result = [];
        $tmdb->checkOptionLanguage($options, $result);
    }

    public function testCheckOptionIncludeAdult()
    {
        $tmdb = new Tmdb('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client()));

        $options['include_adult'] = true;
        $result = [];

        $tmdb->checkOptionIncludeAdult($options, $result);

        $this->assertEquals(true, $result['include_adult']);
    }

    public function testCheckOptionPage()
    {
        $tmdb = new Tmdb('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client()));

        $options['page'] = 3;
        $result = [];

        $tmdb->checkOptionPage($options, $result);

        $this->assertEquals(3, $result['page']);
    }

    public function testCheckOptionExternalSource()
    {
        $tmdb = new Tmdb('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client()));

        $external_sources = ['imdb_id', 'freebase_mid', 'freebase_id','tvdb_id', 'tvrage_id', 'facebook_id', 'twitter_id', 'instagram_id'];
        foreach ($external_sources as $ext) {
            $options['external_source'] = $ext;
            $result = [];

            $tmdb->checkOptionExternalSource($options, $result);

            $this->assertEquals($ext, $result['external_source']);
        }
    }

    public function testCheckOptionSortBy()
    {
        $tmdb = new Tmdb('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client()));

        $options['sort_by'] = 'asc';
        $result = [];

        $tmdb->checkOptionSortBy($options, $result);

        $this->assertEquals('created_at.asc', $result['sort_by']);
    }

    public function testCheckOptionSortByIncorrect()
    {
        $this->expectException(\VfacTmdb\Exceptions\IncorrectParamException::class);
        $tmdb = new Tmdb('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client()));

        $options['sort_by'] = 'bad_value';
        $result = [];

        $tmdb->checkOptionSortBy($options, $result);
    }

    public function testCheckOptionDateRange()
    {
        $tmdb = new Tmdb('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client()));

        $options['start_date'] = '2020-01-01';
        $options['end_date']   = '2020-01-02';
        $result = [];

        $tmdb->checkOptionDateRange($options, $result);

        $this->assertEquals('2020-01-01', $result['start_date']);
        $this->assertEquals('2020-01-02', $result['end_date']);
    }

    public function testCheckOptionDateRangeStartDateIncorrect()
    {
        $this->expectException(\VfacTmdb\Exceptions\IncorrectParamException::class);
        $tmdb = new Tmdb('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client()));

        $options['start_date'] = 'bad_value';
        $options['end_date']   = '2020-01-01';
        $result = [];

        $tmdb->checkOptionDateRange($options, $result);
    }

    public function testCheckOptionDateRangeEndDateIncorrect()
    {
        $this->expectException(\VfacTmdb\Exceptions\IncorrectParamException::class);
        $tmdb = new Tmdb('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client()));

        $options['start_date'] = '2020-01-01';
        $options['end_date']   = 'bad_value';
        $result = [];

        $tmdb->checkOptionDateRange($options, $result);
    }

    public function testCheckOptionExternalSourceIncorrect()
    {
        $this->expectException(\VfacTmdb\Exceptions\IncorrectParamException::class);
        $tmdb = new Tmdb('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client()));

        $options['external_source'] = 'bad_value';
        $result = [];

        $tmdb->checkOptionExternalSource($options, $result);
    }

    public function testMagicalGetterNok()
    {
        $this->expectException(\VfacTmdb\Exceptions\IncorrectParamException::class);
        $tmdb = new Tmdb('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client()));
        $tmdb->test;
    }

    /**
     * @test
     */
    public function testGetConfigurationOK()
    {
        $tmdb = $this->getMockBuilder(\VfacTmdb\Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client())))
                ->setMethods(['sendRequest'])
                ->getMock();

        $json_object = json_decode(file_get_contents('tests/json/configurationOk.json'));
        $tmdb->method('sendRequest')->willReturn($json_object);

        $conf = $tmdb->getConfiguration();

        $this->assertEquals('/3/configuration', parse_url($tmdb->url, PHP_URL_PATH));

        $this->assertInstanceOf(\stdClass::class, $conf);
    }

    /**
     * @test
     */
    public function testGetConfigurationNOK()
    {
        $this->expectException(\VfacTmdb\Exceptions\TmdbException::class);
        $tmdb = $this->getMockBuilder(\VfacTmdb\Tmdb::class)
                ->setConstructorArgs(array('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), new HttpClient(new \GuzzleHttp\Client())))
                ->setMethods(['sendRequest'])
                ->getMock();

        $tmdb->method('sendRequest')->will($this->throwException(new TmdbException()));

        $tmdb->getConfiguration();
    }

    /**
     * @test
     */
    public function testgetRequestHttpError()
    {
        $this->expectException(\Exception::class);
        $guzzleclient = $this->getMockBuilder(\GuzzleHttp\Client::class)
                ->setMethods(['getBody'])
                ->getMock();

        $http_request = $this->getMockBuilder(\VfacTmdb\Interfaces\HttpRequestInterface::class)
        ->setMethods(['getResponse', 'postResponse', 'deleteResponse'])
        ->getMock();

        $http_request->method('getResponse')->willReturn($guzzleclient);

        $tmdb = new Tmdb('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), $http_request);
        $tmdb->getRequest('fake/');
    }

    /**
     * @test
     */
    public function testgetRequestExecError()
    {
        $this->expectException(\Exception::class);
        $guzzleclient = $this->getMockBuilder(\GuzzleHttp\Client::class)
                ->setMethods(['getBody'])
                ->getMock();

        $http_request = $this->getMockBuilder(\VfacTmdb\Interfaces\HttpRequestInterface::class)
        ->setMethods(['getResponse', 'postResponse', 'deleteResponse'])
        ->getMock();

        $http_request->method('getResponse')->willReturn($guzzleclient);

        $tmdb = new Tmdb('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), $http_request);
        $tmdb->base_api_url = 'invalid_url';
        $tmdb->getRequest('action');
    }

    /**
     * @test
     */
    public function testgetRequestHttpErrorNotJson()
    {
        $this->expectException(\Exception::class);
        $guzzleclient = $this->getMockBuilder(\GuzzleHttp\Client::class)
                ->setMethods(['getBody'])
                ->getMock();

        $guzzleclient->method('getBody')->willReturn('Not JSON');

        $http_request = $this->getMockBuilder(\VfacTmdb\Interfaces\HttpRequestInterface::class)
        ->setMethods(['getResponse', 'postResponse', 'deleteResponse'])
        ->getMock();

        $http_request->method('getResponse')->willReturn($guzzleclient);

        $tmdb = new Tmdb('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), $http_request);
        $tmdb->getRequest('action');
    }

    /**
     * @test
     */
    public function testGetRequestOk()
    {
        $guzzleclient = $this->getMockBuilder(\GuzzleHttp\Client::class)
                ->setMethods(['getBody'])
                ->getMock();

        $http_request = $this->getMockBuilder(\VfacTmdb\Interfaces\HttpRequestInterface::class)
        ->setMethods(['getResponse', 'postResponse', 'deleteResponse'])
        ->getMock();

        $tmdb = new Tmdb('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), $http_request);

        $guzzleclient->method('getBody')->willReturn(file_get_contents('tests/json/configurationOk.json'));
        $http_request->method('getResponse')->willReturn($guzzleclient);

        $result = $tmdb->getRequest('test', ['param=1']);

        $this->assertInstanceOf(\stdClass::class, $result);
    }

    /**
     * @test
     */
    public function testPostRequestOk()
    {
        $guzzleclient = $this->getMockBuilder(\GuzzleHttp\Client::class)
                ->setMethods(['getBody'])
                ->getMock();

        $http_request = $this->getMockBuilder(\VfacTmdb\Interfaces\HttpRequestInterface::class)
        ->setMethods(['getResponse', 'postResponse', 'deleteResponse'])
        ->getMock();

        $tmdb = new Tmdb('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), $http_request);

        $guzzleclient->method('getBody')->willReturn(file_get_contents('tests/json/configurationOk.json'));
        $http_request->method('postResponse')->willReturn($guzzleclient);

        $result = $tmdb->postRequest('/test', ['param=1']);

        $this->assertInstanceOf(\stdClass::class, $result);
    }

    /**
     * @test
     */
    public function testDeleteRequestOk()
    {
        $guzzleclient = $this->getMockBuilder(\GuzzleHttp\Client::class)
                ->setMethods(['getBody'])
                ->getMock();

        $http_request = $this->getMockBuilder(\VfacTmdb\Interfaces\HttpRequestInterface::class)
        ->setMethods(['getResponse', 'postResponse', 'deleteResponse'])
        ->getMock();

        $tmdb = new Tmdb('fake_api_key', 3, new \Monolog\Logger('Tmdb', [new \Monolog\Handler\StreamHandler('logs/unittest.log')]), $http_request);

        $guzzleclient->method('getBody')->willReturn(file_get_contents('tests/json/configurationOk.json'));
        $http_request->method('deleteResponse')->willReturn($guzzleclient);

        $result = $tmdb->deleteRequest('/test', ['param=1']);

        $this->assertInstanceOf(\stdClass::class, $result);
    }
}
