<?php

namespace App\Interfaces\Services;

interface ExchangeRateServiceInterface
{
    public function index(); 
    public function store($request); 
    public function update($request, $id);
    public function destroy($id);    
}
