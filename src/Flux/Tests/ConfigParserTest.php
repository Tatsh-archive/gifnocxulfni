<?php
namespace Flux\Tests;
use Flux\ConfigParser;
use Flux\ConfigParserException;

class ConfigParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Flux\ConfigParserException
     * @expectedExceptionCode 2
     * @expectedExceptionMessageRegExp /fopen/
     */
    public function testBadFilename()
    {
        $parser = new ConfigParser();
        $parser->parse('not-a-file');
    } // @codeCoverageIgnore

    public function testNoCommentRead()
    {
        $parser = new ConfigParser();
        $config = $parser->parse(dirname(__FILE__) . '/../Resources/test-config1');

        $this->assertSame($config['host'], 'test.com');
        $this->assertCount(1, $config);
    }

    public function testBoolean()
    {
        $parser = new ConfigParser();
        $config = $parser->parse(dirname(__FILE__) . '/../Resources/test-config2');

        $this->assertSame($config['a'], true);
        $this->assertSame($config['b'], false);

        $this->assertSame($config['c'], true);
        $this->assertSame($config['d'], false);

        $this->assertSame($config['e'], true);
        $this->assertSame($config['f'], false);
    }

    public function testInteger()
    {
        $parser = new ConfigParser();
        $config = $parser->parse(dirname(__FILE__) . '/../Resources/test-config3');

        $this->assertSame($config['a'], 3);
        $this->assertSame($config['b'], 2);
    }

    public function testFloat()
    {
        $parser = new ConfigParser();
        $config = $parser->parse(dirname(__FILE__) . '/../Resources/test-config4');

        $this->assertSame($config['a'], 3.0);
        $this->assertSame($config['b'], 2.1);
        $this->assertSame($config['c'], M_PI);
        $this->assertSame($config['d'], M_E);
    }

    public function testUnicode()
    {
        $parser = new ConfigParser();
        $config = $parser->parse(dirname(__FILE__) . '/../Resources/test-config6');

        $this->assertSame($config['name'], 'ありがとう你好ברוכיםمرحبا');
        $this->assertSame($config['name2'], 'り你וح');
    }

    public function testGetErrors()
    {
        $parser = new ConfigParser();
        $this->assertInternalType('array', $parser->getErrors());
    }
}
