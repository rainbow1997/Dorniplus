<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use \App\Models\Province;
class UsersChart extends BaseChart
{
    protected $provincesTitles;
    protected $provincesCounts;
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function __construct(){
        $this->countsOfProvince();
    }
    public function handler(Request $request): Chartisan
    {
        
        return Chartisan::build()
            ->labels($this->provinces_titles)
            ->dataset('استان ها',  $this->provinces_counts);

    }
    public function countsOfProvince()
    {
      
        $i = 0;
        foreach(Province::all() as $province){
            $this->provinces_titles[$i] = $province->title; 
            $this->provinces_counts[$i] = $province->users()->count();
            $i++;
        }
        
        
    }
}