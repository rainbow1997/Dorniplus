<?php

namespace App\Charts;
use Lava;
use App\Models\Province;

class UsersChart
{
    protected $provincesTitles;
    protected $provincesCounts;
    public function __construct()
    {
        $this->provincesTitles = collect($this->provincesTitles);
        $this->provincesCounts = collect($this->provincesCounts);
        $this->countsOfProvince();

    }

    public function showChart()
    {


        $users = Lava::DataTable();
        $users->addStringColumn('استان ها');
        $users->addNumberColumn('تعداد');
        for($i=0;$i<$this->provincesTitles->count();$i++)
                $users->addRow([$this->provincesTitles[$i],$this->provincesCounts[$i]]);


        Lava::ColumnChart('Users', $users, [
            'title' => 'کاربران استان ها',
            'titleTextStyle' => [
                'color'    => '#eb6b2c',
                'fontSize' => 14
            ]
        ]);

       return view('auth/users_charts');
    }
    public function countsOfProvince()
    {

        foreach(Province::all() as $province){
            $this->provincesTitles->push($province->title);
            $this->provincesCounts->push( $province->users()->count() );
        }

    }
}
