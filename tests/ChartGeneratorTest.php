<?php

namespace DiegoCopat\PacchettoVueJs\Tests;

use PHPUnit\Framework\TestCase;
use DiegoCopat\PacchettoVueJs\ChartGenerator;

class ChartGeneratorTest extends TestCase
{
    public function testGenerateChartConfig()
    {
        $chartData = [10, 20, 30, 40];
        $chartLabels = ['Gen', 'Feb', 'Mar', 'Apr'];
        $generator = new ChartGenerator($chartData, $chartLabels);
        
        $config = $generator->generateChartConfig();
        
        $this->assertIsArray($config);
        $this->assertArrayHasKey('series', $config);
        $this->assertEquals($chartData, $config['series'][0]['data']);
        $this->assertEquals($chartLabels, $config['chartOptions']['xaxis']['categories']);
    }
    
    public function testSetTitle()
    {
        $chartData = [10, 20, 30, 40];
        $generator = new ChartGenerator($chartData);
        
        $newTitle = 'Nuovo Titolo Test';
        $generator->setTitle($newTitle);
        
        $config = $generator->generateChartConfig();
        
        $this->assertEquals($newTitle, $config['chartOptions']['title']['text']);
    }
    
    public function testSetType()
    {
        $chartData = [10, 20, 30, 40];
        $generator = new ChartGenerator($chartData);
        
        $newType = 'bar';
        $generator->setType($newType);
        
        $config = $generator->generateChartConfig();
        
        $this->assertEquals($newType, $config['chartOptions']['chart']['type']);
    }
    
    public function testSetInvalidType()
    {
        $chartData = [10, 20, 30, 40];
        $generator = new ChartGenerator($chartData);
        
        $invalidType = 'invalid_type';
        $defaultType = 'line';
        $generator->setType($invalidType);
        
        $config = $generator->generateChartConfig();
        
        // Should remain the default type
        $this->assertEquals($defaultType, $config['chartOptions']['chart']['type']);
    }
}