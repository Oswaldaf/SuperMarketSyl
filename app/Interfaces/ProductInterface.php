<?php

namespace App\Interfaces;

interface ProductInterface
{
    public function index();
    public function show($id);
    public function store(array $data);
    public function update(array $data, $id);
    public function delete($id);
    public function chartByCategory();
    public function chartBySale();
    public function chartBilan();
    public function chartCategoriesBilan();
}
