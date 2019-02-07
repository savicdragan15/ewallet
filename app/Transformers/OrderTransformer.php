<?php

namespace App\Transformers;

class OrderTransformer
{
    /**
     * @param $data
     * @return array
     */
    public static function transformForChart($data)
    {
        $labels = [];
        $values = [];

        foreach ($data as $value) {
            $labels[] = $value->month;
            $values[] = $value->sum;
        }

        $data = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Spent money by Month',
                    'data' => $values,
                    'backgroundColor' => '#3b8dbb',
                    'fillColor' => '#3b8dbb', // react chartJS
                ]
            ]
        ];

        return $data;
    }
}
