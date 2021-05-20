<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\MappingField;

class MappingFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name_mapping_1 = new MappingField($this->definition(
            1000, 
            1006,
            1002,
            'model',
            1000
        ));

        $name_mapping_1->save();

        $name_mapping_2 = new MappingField($this->definition(
            1001, 
            1007,
            1003,
            'model',
            1000
        ));

        $name_mapping_2->save();

        $id_mapping = new MappingField($this->definition(
            1002, 
            1004,
            1000,
            'model',
            1000
        ));

        $id_mapping->save();
    }

    private function definition($id, $output_field, $input_field, $input_field_type, $mapping_id)
    {
        $parameters = [
            'id' => $id,
            'output_field' => $output_field,
            'input_field' => $input_field,
            'input_field_type' => $input_field_type,
            'mapping_id' => $mapping_id
        ];

        return $parameters;
    }
}
