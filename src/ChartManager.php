<?php

namespace DiegoCopat\PacchettoVueJs;

class ChartManager
{
    /**
     * Ottieni il percorso degli asset
     *
     * @return string
     */
    public static function getAssetsPath()
    {
        return __DIR__ . '/../dist';
    }

    /**
     * Genera un'istanza di ChartGenerator
     *
     * @param array $data
     * @param array $labels
     * @return ChartGenerator
     */
    public function createGenerator(array $data = [], array $labels = [])
    {
        return new ChartGenerator($data, $labels);
    }

    /**
     * Genera un'istanza di VueChartComponent
     * 
     * @param ChartGenerator $generator
     * @param string $componentName
     * @return VueChartComponent
     */
    public function createComponentGenerator(ChartGenerator $generator, string $componentName = 'ChartComponent')
    {
        return new VueChartComponent($generator, $componentName);
    }
}