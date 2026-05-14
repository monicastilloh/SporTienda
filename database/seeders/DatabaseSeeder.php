<?php
namespace Database\Seeders;

use App\Models\{User, Category, Product};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        // Usuarios
        User::create(['name'=>'Administrador','email'=>'admin@sportienda.com','password'=>Hash::make('password'),'role'=>'admin','active'=>true]);
        User::create(['name'=>'Empleado 1','email'=>'empleado@sportienda.com','password'=>Hash::make('password'),'role'=>'empleado','active'=>true]);
        User::create(['name'=>'Cliente Demo','email'=>'cliente@sportienda.com','password'=>Hash::make('password'),'role'=>'cliente','active'=>true]);

        // Categorías
        $cats = [
            ['name'=>'Fútbol','slug'=>'futbol','icon'=>'⚽'],
            ['name'=>'Básquetbol','slug'=>'basquetbol','icon'=>'🏀'],
            ['name'=>'Tenis','slug'=>'tenis','icon'=>'🎾'],
            ['name'=>'Natación','slug'=>'natacion','icon'=>'🏊'],
            ['name'=>'Ciclismo','slug'=>'ciclismo','icon'=>'🚴'],
            ['name'=>'Gym & Fitness','slug'=>'gym-fitness','icon'=>'🏋️'],
        ];
        foreach ($cats as $cat) {
            Category::create(array_merge($cat, ['active'=>true]));
        }

        // Productos de ejemplo
        $products = [
            ['category_id'=>1,'name'=>'Balón Profesional Adidas','price'=>850,'stock'=>20],
            ['category_id'=>1,'name'=>'Zapatos de Fútbol Nike Mercurial','price'=>2500,'stock'=>15],
            ['category_id'=>2,'name'=>'Balón de Básquetbol Spalding','price'=>1200,'stock'=>10],
            ['category_id'=>3,'name'=>'Raqueta Head Ti.S6','price'=>1800,'stock'=>8],
            ['category_id'=>4,'name'=>'Lentes de Natación Speedo','price'=>350,'stock'=>25],
            ['category_id'=>6,'name'=>'Mancuernas 5kg Par','price'=>600,'stock'=>30],
            ['category_id'=>6,'name'=>'Cuerda para Saltar Pro','price'=>280,'stock'=>40],
        ];
        foreach ($products as $p) {
            Product::create(array_merge($p, ['active'=>true, 'slug'=>Str::slug($p['name']).'-'.uniqid()]));
        }
    }
}