<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calculation;
use App\Events\NewCalculationEvent;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CalculatorController extends Controller
{
    public function saveCalculationResult(Request $request)
    {
        try {
            $result = $request->input('result');
            $expression = $request->input('expression');

            // Additional check: Ensure both 'result' and 'expression' are present
            if (!$result || !$expression) {
                return inertia('HomePage', [
                    'success' => false,
                    'error' => 'Invalid input data',
                ]);
            }

            $user = Auth::user();
            // Save the result to the database using your Calculation model
            $calculation = $user->calculations()->create([
                'expression' => $expression,
                'result' => $result
            ]);

            // Trigger the event to broadcast the new calculation
            event(new NewCalculationEvent($calculation));

            // Log the saved calculation result
            \Log::info('Calculation result saved successfully:', ['calculation' => $calculation]);

            // Return the Inertia view
            return inertia('HomePage', [
                'success' => true,
                'calculation' => $calculation, 
            ]);
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Failed to save calculation result:', ['error' => $e->getMessage()]);

            return inertia('HomePage', [
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }


    public function showLastCalculations()
    {
        $user = Auth::user();
        // Retrieve the last 10 calculations from the database
        $lastCalculations = $user->calculations()->latest()->take(10)->get();

        // Log the data to the console for debugging
        \Log::info('Last calculations:', ['lastCalculations' => $lastCalculations]);

        // Return an Inertia view with the calculations data
        return inertia('LastCalculations', [
            'lastCalculations' => $lastCalculations,
        ]);
    }

}
