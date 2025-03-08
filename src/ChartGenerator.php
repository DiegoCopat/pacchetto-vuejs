<?php

namespace DiegoCopat\PacchettoVueJs;

class ChartGenerator
{
    private $chartData;
    private $chartLabels;
    private $chartTitle;
    private $chartType;
    private $chartColors;
    
    public function __construct(array $chartData = [], array $chartLabels = [])
    {
        $this->chartData = $chartData;
        $this->chartLabels = $chartLabels;
        $this->chartTitle = 'Grafico';
        $this->chartType = 'line';
        $this->chartColors = ['#5C6AC4'];
    }
    
    public function setData(array $data): self
    {
        $this->chartData = $data;
        return $this;
    }
    
    public function setLabels(array $labels): self
    {
        $this->chartLabels = $labels;
        return $this;
    }
    
    public function setTitle(string $title): self
    {
        $this->chartTitle = $title;
        return $this;
    }
    
    public function setType(string $type): self
    {
        $validTypes = ['line', 'bar', 'pie', 'donut', 'area', 'radar'];
        if (in_array($type, $validTypes)) {
            $this->chartType = $type;
        }
        return $this;
    }
    
    public function setColors(array $colors): self
    {
        $this->chartColors = $colors;
        return $this;
    }
    
    public function generateChartConfig(): array
    {
        return [
            'series' => [
                [
                    'name' => 'Dati',
                    'data' => $this->chartData
                ]
            ],
            'chartOptions' => [
                'chart' => [
                    'type' => $this->chartType,
                    'fontFamily' => 'Helvetica, Arial, sans-serif',
                    'toolbar' => [
                        'show' => false
                    ],
                    'dropShadow' => [
                        'enabled' => true,
                        'color' => '#000',
                        'top' => 18,
                        'left' => 7,
                        'blur' => 10,
                        'opacity' => 0.2
                    ]
                ],
                'colors' => $this->chartColors,
                'stroke' => [
                    'curve' => 'smooth',
                    'width' => 3
                ],
                'grid' => [
                    'borderColor' => '#e0e0e0',
                    'row' => [
                        'colors' => ['#f3f3f3', 'transparent'],
                        'opacity' => 0.5
                    ]
                ],
                'markers' => [
                    'size' => 6,
                    'colors' => $this->chartColors,
                    'strokeColors' => '#fff',
                    'strokeWidth' => 2
                ],
                'xaxis' => [
                    'categories' => $this->chartLabels
                ],
                'dataLabels' => [
                    'enabled' => false
                ],
                'title' => [
                    'text' => $this->chartTitle,
                    'align' => 'center',
                    'style' => [
                        'fontSize' => '18px',
                        'fontWeight' => 'bold'
                    ]
                ],
                'tooltip' => [
                    'theme' => 'dark',
                    'x' => [
                        'show' => true,
                    ]
                ],
                'theme' => [
                    'mode' => 'light'
                ]
            ]
        ];
    }
    
    public function renderJsonConfig(): string
    {
        return json_encode($this->generateChartConfig());
    }
}