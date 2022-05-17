<?php

use App\Models\MenuItem;
use App\Models\Seo;
use App\Models\StaticTrans;
use Illuminate\Database\Seeder;

class DifferentTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //SEO
        $seo = Seo::where(['page' => MenuItem::PAGE_MAIN])->first();

        if(empty($seo)) {
            $seo = new Seo();
            $seo->page = MenuItem::PAGE_MAIN;
            $seo->meta_title = "Main";
            $seo->meta_description = "Main desc";
            $seo->meta_keywords = "HTML,CSS,JavaScript";
            $seo->canonical = "/";
            $seo->save();
        }




        $seo = Seo::where(['page' => MenuItem::PAGE_AUTH])->first();

        if(empty($seo)) {
            $seo = new Seo();
            $seo->page = MenuItem::PAGE_AUTH;
            $seo->meta_title = "Authentification";
            $seo->meta_description = "Authentification";
            $seo->meta_keywords = "Authentification";
            $seo->canonical = "/";
            $seo->save();
        }

        $seo = Seo::where(['page' => MenuItem::PAGE_CHECKOUT])->first();

        if(empty($seo)) {
            $seo = new Seo();
            $seo->page = MenuItem::PAGE_CHECKOUT;
            $seo->meta_title = "Checkout";
            $seo->meta_description = "Checkout";
            $seo->meta_keywords = "Checkout";
            $seo->canonical = "/";
            $seo->save();
        }

        $seo = Seo::where(['page' => MenuItem::PAGE_THANKYOU])->first();

        if(empty($seo)) {
            $seo = new Seo();
            $seo->page = MenuItem::PAGE_THANKYOU;
            $seo->meta_title = "Thank you";
            $seo->meta_description = "Thank you";
            $seo->meta_keywords = "Thank you";
            $seo->canonical = "/";
            $seo->save();
        }



        $seo = Seo::where(['page' => MenuItem::PAGE_CONTACT])->first();

        if(empty($seo)) {
            $seo = new Seo();
            $seo->page = MenuItem::PAGE_CONTACT;
            $seo->meta_title = "Contact";
            $seo->meta_description = "Contact";
            $seo->meta_keywords = "Contact";
            $seo->canonical = "/contact";
            $seo->save();
        }


    }
}
