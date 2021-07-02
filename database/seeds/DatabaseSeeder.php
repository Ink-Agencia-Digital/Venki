<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        
        DB::table('users')->insert([
            'profile_id'=>1,
            'name'=>'Super',
            'lastname'=>'Admin',
            'email'=>'Superadmin@gmail.com',
            'password'=>bcrypt('admin'),
        ]);
        

        /*DB::table('oauth_clients')->truncate();

        DB::table('oauth_clients')->insert([
            [
                'id' => "90ef3f03-b692-496e-9240-c6486e4c8c51",
                'name' => "App",
                'secret' => 'gRkm3DmM8DNwhDS5l7UYkUMkJiFa4tgRYgviMRVf',
                'redirect' => 'http://localhost',
                'personal_access_client' => 0,
                'password_client' => 1,
                'revoked' => 0,
                'created_at' => '2019-06-05 14:22:20',
                'updated_at' => '2019-06-05 14:22:20'
            ],
        ]);*/

        // DB::table('questions')->truncate();
        /*DB::table('questions')->insert([
            'question' => '¿Cuales de los siguientes son los grupos de alimentos?',
            'survey_id' => 1,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => '¿Qué es una  alimentación  saludable?',
            'survey_id' => 1,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => '¿Qué componentes  debería tener una  bebida hidratante?',
            'survey_id' => 1,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => '¿Cuál de las  siguientes  proteínas tienen  mayor efectividad  en la prevención  del catabolismo  muscular?',
            'survey_id' => 1,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => 'La alimentación  influye en las  categorías de la  recuperación:',
            'survey_id' => 1,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => 'Para obtener  beneficios en el  estado de salud, el  orden de comer los  alimentos debería  ser:',
            'survey_id' => 1,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => 'Comer es...',
            'survey_id' => 1,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => '¿Cuál o cuáles son  los periodos de la  programación  nutricional  muscular?',
            'survey_id' => 1,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => '¿Las necesidades  nutricionales de las  personas son:',
            'survey_id' => 1,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => 'Para la  recuperación  postentrenamiento  es importante:',
            'survey_id' => 1,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => '¿Cuál es la  importancia de las  calorías?',
            'survey_id' => 1,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => '¿Qué puede ocurrir  si la alimentación  es insuficiente?',
            'survey_id' => 1,
            'category_id' => 7,
        ]);

        // survey 2

        DB::table('questions')->insert([
            'question' => '¿Cuales de los siguientes son los grupos de alimentos?',
            'survey_id' => 2,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => '¿Qué es una  alimentación  saludable?',
            'survey_id' => 2,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => '¿Qué componentes  debería tener una  bebida hidratante?',
            'survey_id' => 2,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => '¿Cuál de las  siguientes  proteínas tienen  mayor efectividad  en la prevención  del catabolismo  muscular?',
            'survey_id' => 2,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => 'La alimentación  influye en las  categorías de la  recuperación:',
            'survey_id' => 2,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => 'Para obtener  beneficios en el  estado de salud, el  orden de comer los  alimentos debería  ser:',
            'survey_id' => 2,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => 'Comer es...',
            'survey_id' => 2,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => '¿Cuál o cuáles son  los periodos de la  programación  nutricional  muscular?',
            'survey_id' => 2,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => '¿Las necesidades  nutricionales de las  personas son:',
            'survey_id' => 2,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => 'Para la  recuperación  postentrenamiento  es importante:',
            'survey_id' => 2,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => '¿Cuál es la  importancia de las  calorías?',
            'survey_id' => 2,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => '¿Qué puede ocurrir  si la alimentación  es insuficiente?',
            'survey_id' => 2,
            'category_id' => 7,
        ]);

        // survey 3

        DB::table('questions')->insert([
            'question' => '¿Cuales de los siguientes son los grupos de alimentos?',
            'survey_id' => 3,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => '¿Qué es una  alimentación  saludable?',
            'survey_id' => 3,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => '¿Qué componentes  debería tener una  bebida hidratante?',
            'survey_id' => 3,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => '¿Cuál de las  siguientes  proteínas tienen  mayor efectividad  en la prevención  del catabolismo  muscular?',
            'survey_id' => 3,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => 'La alimentación  influye en las  categorías de la  recuperación:',
            'survey_id' => 3,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => 'Para obtener  beneficios en el  estado de salud, el  orden de comer los  alimentos debería  ser:',
            'survey_id' => 3,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => 'Comer es...',
            'survey_id' => 3,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => '¿Cuál o cuáles son  los periodos de la  programación  nutricional  muscular?',
            'survey_id' => 3,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => '¿Las necesidades  nutricionales de las  personas son:',
            'survey_id' => 3,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => 'Para la  recuperación  postentrenamiento  es importante:',
            'survey_id' => 3,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => '¿Cuál es la  importancia de las  calorías?',
            'survey_id' => 3,
            'category_id' => 7,
        ]);

        DB::table('questions')->insert([
            'question' => '¿Qué puede ocurrir  si la alimentación  es insuficiente?',
            'survey_id' => 3,
            'category_id' => 7,
        ]);*/


    }
}
