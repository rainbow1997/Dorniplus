<?php

namespace App\Charts;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Support\Collection;
use Lava;

class UsersChart extends Controller
{
    protected Collection $provincesTitles;
    protected Collection $provincesCounts;

    public function __construct()
    {
        $this->middleware('permission:chart-show', ['only' => ['showChart']]);
        $this->countsOfProvince();


    }

    public function countsOfProvince()
    {
        $this->provincesTitles = collect();
        $this->provincesCounts = collect();
        foreach (Province::all() as $province) {
            if($province == null)
                dd($province);
            $this->provincesTitles->push($province->title);
            $this->provincesCounts->push($province->users()->count());
        }

    }

    public function showChart()
    {


        $users = Lava::DataTable();
        $users->addStringColumn('استان ها');
        $users->addNumberColumn('تعداد');
        for ($i = 0; $i < $this->provincesTitles->count(); $i++)
            $users->addRow([$this->provincesTitles[$i], $this->provincesCounts[$i]]);


        Lava::ColumnChart('Users', $users, [
            'title' => 'کاربران استان ها',
            'titleTextStyle' => [
                'color' => '#eb6b2c',
                'fontSize' => 14
            ]
        ]);

        return view('auth/users_charts');
    }
}
