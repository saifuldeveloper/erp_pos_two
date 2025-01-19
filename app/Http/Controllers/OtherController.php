<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class OtherController extends Controller
{
    public function migrate()
    {
        Artisan::call('migrate:fresh --seed');
        return redirect('/');
    }

    public function clear()
    {
        Artisan::call('optimize:clear');
        return redirect('/');
    }

    public function composer()
    {
        exec('composer update');
        exec('composer dump-autoload');
        return redirect('/');
    }

    public function iseed()
    {
        $tables = DB::select('SHOW TABLES');
        $prevent_tables = ['failed_jobs', 'migrations', 'password_reset_tokens', 'personal_access_tokens', 'sessions'];
        foreach ($tables as $table) {
            $table_name = 'Tables_in_' . env('DB_DATABASE');
            $table_name = $table->$table_name;
            if (!in_array($table_name, $prevent_tables))
                Artisan::call('iseed ' . $table_name . ' --force');
        }
        return redirect('/');
    }

    public function color()
    {
        $product_colors = DB::table('products')->pluck('variant_value');
        $colors = [];
        foreach ($product_colors as $product_color) {
            $product_color = json_decode($product_color);
            if (is_array($product_color)) {
                $colorList = explode(',', $product_color[0]);
                foreach ($colorList as $color) {
                    if (!in_array($color, $colors)) {
                        $colors[] = $color;
                    }
                }
            }
        }
        sort($colors);
        $colors = array_unique($colors);
        foreach ($colors as $color) {
            DB::table('colors')->insert([
                'name' => $color
            ]);
        }
    }
}
