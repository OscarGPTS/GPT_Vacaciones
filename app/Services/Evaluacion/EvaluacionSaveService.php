<?php

namespace App\Services\Evaluacion;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SelectedValueCardinal;
use App\Models\SelectedValueTechnical;
use App\Models\PerformanceSelectedOption;
use App\Models\SelectedValueComunication;
use App\Models\SelectedValueEnglish;

class EvaluacionSaveService
{


    public function guardarRespuestasPerformance(Request $request, $user)
    {

        $respuestas = [
            $request->respuesta1,
            $request->respuesta2,
            $request->respuesta3,
            $request->respuesta4,
            $request->respuesta5,
            $request->respuesta6
        ];


        DB::beginTransaction();

        try {
            foreach ($respuestas as $respuesta) {

                PerformanceSelectedOption::create([
                    'performance_id' => $respuesta['pregunta'],
                    'performance_option_id' => $respuesta['opcion'],
                    'user_id' => $user
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {


            DB::rollback();
        }

        return true;
    }
    public function guardarRespuestasTecnicas($respuestas, $user)
    {
        DB::beginTransaction();

        try {
            foreach ($respuestas as $respuesta) {

                SelectedValueTechnical::create([
                    'skill_id' => $respuesta['pregunta'],
                    'option_id' => $respuesta['opcion'],
                    'user_id' => $user
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {


            DB::rollback();
        }

        return true;
    }

    public function guardarRespuestasCardinales($respuestas, $user)
    {
        DB::beginTransaction();

        try {
            foreach ($respuestas as $respuesta) {

                SelectedValueCardinal::create([
                    'skill_id' => $respuesta['pregunta'],
                    'option_id' => $respuesta['opcion'],
                    'user_id' => $user
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return true;
    }

    public function guardarRespuestasGenericas($ingles, $escritura, $user)
    {
        DB::beginTransaction();

        try {
            SelectedValueEnglish::create([
                'english_skill_id' => $ingles,
                'user_id' => $user
            ]);

            SelectedValueComunication::create([
                'comunication_skill_id' => $escritura,
                'user_id' => $user
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return true;
    }

    public function guardarRetroalimentacion($respuestas, $user)
    {
        DB::beginTransaction();

        try {
            Feedback::create([
                'area_strength' => $respuestas['areaStrength'],
                'area_opportunity' => $respuestas['areaOpportunity'],
                'comment' => $respuestas['comment'],
                'user_id' => $user
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return true;
    }
}
