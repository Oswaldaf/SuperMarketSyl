<?php

namespace App\Repositories;

use App\Charts\ProductChart;
use App\Interfaces\ProductInterface;
use App\Models\Category;
use App\Models\Product;
use App\Models\sales_items;
use App\Models\sale;

class ProductRepository implements ProductInterface
{
    public function index()
    {
        return Product::all();
    }

    public function show($id)
    {
        return Product::findOrFail($id);
    }

    public function store(array $data)
    {
        return Product::create($data);
    }

    public function update(array $data, $id)
    {
        return Product::findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return Product::destroy($id);
    }

    public function chartByCategory()
    {

        $data = Product::select('category_id')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('category_id')
            ->get();

        $json_data = json_decode($data, true);

        $names = [];
        $count = [];

        $i = 0;

        foreach ($json_data as $item) {
            $i++;
            $count[] = $item['count'];
            $names[] = Category::find($item['category_id'])->name;
        }

        $chart = new ProductChart;
        $chart->labels($names);
        $chart->dataset("Ordinateurs", "pie", $count)->options([
            'backgroundColor' => ['#046e24', "#dd4c09", "#0b7ad4", "#b20bd4", "#d1163e", "#178897", "#587512"],
        ]);

        return $chart;
    }




    public function chartBySale()
    {
        // Créer la première instance de SalesChart
        $salesChart1 = new ProductChart;

        // Définir les labels pour les mois
        $salesChart1->labels(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);

        // Récupérer les données de vente mensuelles
        $salesData1 = sale::selectRaw('SUM(total_amount) as total, strftime("%m", created_at) as month')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();
        // Initialiser les données de vente mensuelles
        $salesMonthlyData1 = array_fill(1, 12, 0);

        // Remplir les données de vente mensuelles avec les données récupérées
        foreach ($salesData1 as $month => $total) {
            $salesMonthlyData1[(int)$month] = $total;
        }

        // Couleurs pour chaque mois
        $colors1 = [
            'rgba(255, 99, 132, 0.2)', // January
            'rgba(54, 162, 235, 0.2)', // February
            'rgba(255, 206, 86, 0.2)', // March
            'rgba(75, 192, 192, 0.2)', // April
            'rgba(153, 102, 255, 0.2)', // May
            'rgba(255, 159, 64, 0.2)', // June
            'rgba(255, 99, 132, 0.2)', // July
            'rgba(54, 162, 235, 0.2)', // August
            'rgba(255, 206, 86, 0.2)', // September
            'rgba(75, 192, 192, 0.2)', // October
            'rgba(153, 102, 255, 0.2)', // November
            'rgba(255, 159, 64, 0.2)' // December
        ];

        $borderColors1 = [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
        ];

        // Ajouter les données et les couleurs au graphique
        $salesChart1->dataset('statistiques de vente de chaque mois dans l’année', 'bar', array_values($salesMonthlyData1))
            ->backgroundColor($colors1)
            ->color($borderColors1)
            ->options([
                'borderWidth' => 1
            ]);
        // Configurer les options du graphique
        $salesChart1->options([
            'responsive' => true,
            'maintainAspectRatio' => false,
            'scales' => [
                'yAxes' => [[
                    'ticks' => [
                        'beginAtZero' => true,
                    ],
                ]],
            ],
        ]);
        return $salesChart1;
    }



    public function chartBilan()
    {


        // Créer la deuxième instance de SalesChart comme un LineChart
        $salesChart2 = new ProductChart;

        // Définir les labels pour les mois
        $salesChart2->labels(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);

        // Récupérer les données de vente mensuelles
        $salesData2 = sale::selectRaw('Count(*) as total, strftime("%m", created_at) as month')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Initialiser les données de vente mensuelles
        $salesMonthlyData2 = array_fill(1, 12, 0);

        // Remplir les données de vente mensuelles avec les données récupérées
        foreach ($salesData2 as $month => $total) {
            $salesMonthlyData2[(int)$month] = $total;
        }
        // Couleurs pour chaque mois
        $colors2 = [
            'rgba(75, 192, 192, 0.2)', // January
            'rgba(153, 102, 255, 0.2)', // February
            'rgba(255, 159, 64, 0.2)', // March
            'rgba(255, 99, 132, 0.2)', // April
            'rgba(54, 162, 235, 0.2)', // May
            'rgba(255, 206, 86, 0.2)', // June
            'rgba(75, 192, 192, 0.2)', // July
            'rgba(153, 102, 255, 0.2)', // August
            'rgba(255, 159, 64, 0.2)', // September
            'rgba(255, 99, 132, 0.2)', // October
            'rgba(54, 162, 235, 0.2)', // November
            'rgba(255, 206, 86, 0.2)' // December
        ];

        $borderColors2 = [
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)'
        ];

        // Ajouter les données et les couleurs au graphique
        $salesChart2->dataset('statistiques de vente global de chaque mois dans
l’année
', 'line', array_values($salesMonthlyData2))
            ->backgroundColor($colors2)
            ->color($borderColors2)
            ->options([
                'borderWidth' => 1
            ]);

        // Configurer les options du graphique
        $salesChart2->options([
            'responsive' => true,
            'maintainAspectRatio' => false,
            'scales' => [
                'yAxes' => [[
                    'ticks' => [
                        'beginAtZero' => true,
                    ],
                ]],
            ]
        ]);
        return $salesChart2;
    }



    public function chartCategoriesBilan()
    {

        
        $data = sales_items::select('product_id')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('product_id')
            ->get();

        $json_data = json_decode($data, true);

        $names = [];
        $count = [];

        $i = 0;

        foreach ($json_data as $item) {
            $i++;
            $count[] = $item['count'];
            $names[] = Product::find($item['product_id'])->name;
        }

        $chart3 = new ProductChart;
        $chart3->labels($names);
        $chart3->dataset("Ordinateurs", "pie", $count)->options([
            'backgroundColor' => ['#046e24', "#dd4c09", "#0b7ad4", "#b20bd4", "#d1163e", "#178897", "#587512"],
        ]);

        return $chart3;
        
}
}