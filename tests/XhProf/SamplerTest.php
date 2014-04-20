<?php

namespace XhProf;

/**
 * @requires extension xhprof
 */
class SamplerTest extends \PHPUnit_Framework_TestCase
{
    protected $sampler;

    protected function setUp()
    {
        $this->sampler = new Sampler();
    }

    protected function tearDown()
    {
        $this->sampler = null;
    }

    public function testBasicSampling()
    {
        $this->sampler->start();

        function funcA () {
            usleep(200000);
        };

        function funcB() {
            usleep(100000);
        };

        $i = 3;
        while ($i--) {
            funcA();
            funcB();
        }

        $data = $this->sampler->stop();

        $countA = array_reduce($data, function ($result, $value) {
            return $result + (int)('main()==>XhProf\funcA==>usleep' === $value);
        });

        $countB = array_reduce($data, function ($result, $value) {
            return $result + (int)('main()==>XhProf\funcB==>usleep' === $value);
        });

        $this->assertTrue($countA/$countB <= 2.5);
        $this->assertTrue($countA/$countB >= 1.5);
    }
} 