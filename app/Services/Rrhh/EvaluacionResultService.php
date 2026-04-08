<?php

namespace App\Services\Rrhh;

use App\Models\User;
use App\Models\Feedback;
use App\Models\SelectedValueEnglish;
use App\Models\SelectedValueCardinal;
use App\Models\SelectedValueTechnical;
use App\Models\PerformanceSelectedOption;
use App\Models\SelectedValueComunication;

class EvaluacionResultService
{
    private $user;
    private $year;

    public function __construct(User $user, $year)
    {
        $this->user = $user;
        $this->year = $year;
    }


    public function existeCalificacionPerformance()
    {
        $existsValues = PerformanceSelectedOption::where('user_id', $this->user->id)
            ->whereYear('created_at', $this->year)
            ->count();
        if ($existsValues > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function existeCalificacionCardinalidad()
    {
        $existsValues = SelectedValueCardinal::where('user_id', $this->user->id)
            ->whereYear('created_at', $this->year)
            ->count();
        if ($existsValues > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function existeCalificacionTecnica()
    {
        $existsValues = SelectedValueTechnical::where('user_id', $this->user->id)
            ->whereYear('created_at', $this->year)
            ->count();
        if ($existsValues > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function existeCalificacionCardinal()
    {
        $existsValues = SelectedValueCardinal::where('user_id', $this->user->id)
            ->whereYear('created_at', $this->year)
            ->count();
        if ($existsValues > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function existeCalificacionGenericas()
    {
        $existsValuesEnglish = SelectedValueEnglish::where('user_id', $this->user->id)
            ->whereYear('created_at', $this->year)
            ->count();

        $existsValuesComunication = SelectedValueComunication::where('user_id', $this->user->id)
            ->whereYear('created_at', $this->year)
            ->count();


        if ($existsValuesEnglish > 0 && $existsValuesComunication > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function existeFeedback()
    {
        $existsValues = Feedback::where('user_id', $this->user->id)
            ->whereYear('created_at', $this->year)
            ->count();

        if ($existsValues > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function obtenerCalificacionPerformance()
    {
        $labels = [];
        $data = [];
        $resultScore = 0;
        $resultPercentage = 0;
        $result = [];

        $optionsSelected = PerformanceSelectedOption::with(['option', 'indicator'])
            ->where('user_id', $this->user->id)
            ->whereYear('created_at', $this->year)
            ->get();

        foreach ($optionsSelected as $optionSelected) {
            $resultScore += $optionSelected->option->score;
            $resultPercentage += $optionSelected->option->percentage;

            array_push($labels, $optionSelected->indicator->category);
            array_push($data, $optionSelected->option->score);
        }
        $resultScore = $resultScore / 6;
        $resultPercentage = $resultPercentage / 6;

        $result['score'] = number_format($resultScore, 2);
        $result['percentage'] = number_format($resultPercentage, 2);
        $result['labels'] = $labels;
        $result['data'] = $data;

        return $result;
    }

    public function obtenerCalificacionConocimientos()
    {
        $optionsSelected = SelectedValueTechnical::with(['option', 'skill'])
            ->where('user_id', $this->user->id)
            ->whereYear('created_at', $this->year)
            ->get();

        $actualScore = 0;
        $expectedScore = 0;
        $data = [];
        $labels = [];

        foreach ($optionsSelected as $optionSelected) {
            $actualScore += $optionSelected->option->value;

            array_push($labels, $optionSelected->skill->name);
            array_push($data, $optionSelected->option->value);
            $expectedScore += 4;
        }
        $resultado['total'] = number_format(($actualScore / $expectedScore) * 60, 2);
        $resultado['labels'] = $labels;
        $resultado['data'] = $data;

        return $resultado;
    }
    public function obtenerCalificacionHabilidades()
    {
        // $user = User::with('positionHierarchy')->find($user);

        $optionsSelected = SelectedValueCardinal::with(['skill', 'option'])
            ->where('user_id', $this->user->id)
            ->whereYear('created_at', $this->year)
            ->get();

        $actualScore = 0;
        $data = [];
        $labels = [];

        foreach ($optionsSelected as $optionSelected) {
            $actualScore += $optionSelected->option->value;
            array_push($labels, $optionSelected->skill->competence);
            array_push($data, $optionSelected->option->value);
        }

        $result = number_format(($actualScore / $this->user->positionHierarchy->expected_value) * 20, 2);
        if ($result > 20) {
            $result = 20;
        }
        $resultado['total'] = $result;
        $resultado['labels'] = $labels;
        $resultado['data'] = $data;

        return $resultado;
    }

    public function obtenerFeedback()
    {
        $feedback = Feedback::where('user_id', $this->user->id)
            ->whereYear('created_at', $this->year)
            ->first()
            ->toArray();

        return $feedback;
    }

    public function generarCalificacionTotal()
    {
        if (!$this->existenTodasCalificaciones()) {
            return false;
        }

        $calificaciones['escolaridad'] = $this->user->personalData->education_level_score;
        $calificaciones['experiencia'] = 10;
        $calificaciones['conocimientos'] = $this->obtenerCalificacionConocimientos();
        $calificaciones['habilidades'] = $this->obtenerCalificacionHabilidades();
        $calificaciones['feedback'] = $this->obtenerFeedback();
        $calificaciones['general']['labels'] = ['Experiencia', 'Escolaridad', 'Conocimientos', 'Habilidades'];
        $calificaciones['general']['data'] = [
            $calificaciones['experiencia'],
            $calificaciones['escolaridad'],
            $calificaciones['conocimientos']['total'],
            $calificaciones['habilidades']['total']
        ];

        $calificaciones['final'] = ($calificaciones['escolaridad'] +
            $calificaciones['experiencia'] +
            $calificaciones['conocimientos']['total'] +
            $calificaciones['habilidades']['total']
        );

        return $calificaciones;
    }


    public function existenTodasCalificaciones()
    {
        if (
            $this->existeCalificacionTecnica() &&
            $this->existeCalificacionCardinalidad() &&
            $this->existeCalificacionGenericas() &&
            $this->existeFeedback()
        ) {
            return true;
        } else {
            return false;
        }
    }
}
