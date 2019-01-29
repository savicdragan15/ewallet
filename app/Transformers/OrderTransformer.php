<?php

namespace App\Transformers;

class OrderTransformer
{
    public static function transformForChart($data)
    {
        $labels = [];
        $values = [];

        foreach ($data as $value) {
            $labels[] = $value->month;
            $values[] = number_format($value->sum, 3, ',', '.');
        }

        $data = [
            'labels' => $labels,
            'data' => $values,
        ];

        return $data;
    }
}
