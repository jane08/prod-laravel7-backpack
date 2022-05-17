<?php

use App\Models\MenuItem;
use App\Models\StaticFile;
use App\Models\StaticTrans;
use Illuminate\Database\Seeder;

class StaticTransSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Main
        $staticTrans = StaticTrans::where(['keyword' => 'main_search_text','page' => MenuItem::PAGE_MAIN])->first();

        if(empty($staticTrans)) {
            $staticTrans = new StaticTrans();
            $staticTrans->page = MenuItem::PAGE_MAIN;
            $staticTrans->content = 'Search all products';
            $staticTrans->keyword = 'main_search_text';
            $staticTrans->save();
        }


    }


}
