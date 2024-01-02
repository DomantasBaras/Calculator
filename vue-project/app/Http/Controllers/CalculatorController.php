<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calculation;
use App\Events\NewCalculationEvent;

class CalculatorController extends Controller
{
    public function saveCalculationResult(Request $request)
    {
        try {
            // Assuming 'result' is the key sent from the Vue.js component
            $result = $request->input('result');
            $expression = $request->input('expression');
            
            // Additional check: Ensure both 'result' and 'expression' are present
            if (!$result || !$expression) {
                return inertia('HomePage', [
                    'success' => false,
                    'error' => 'Invalid input data',
                ]);
            }

            // Save the result to the database using your Calculation model
            $calculation = Calculation::create([
                'expression' => $expression,
                'result' => $result
            ]);
            

            // Log the saved calculation result
            \Log::info('Calculation result saved successfully:', ['calculation' => $calculation]);

            return inertia('HomePage', [
                'success' => true,
                'calculation' => $calculation, // Pass the calculation to the view
            ]);
            event(new NewCalculationEvent($calculation));

            // Return the Inertia view
            return inertia('HomePage', [
                'lastCalculations' => $lastCalculations,
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
        // Retrieve the last 10 calculations from the database
        $lastCalculations = Calculation::latest()->take(10)->get();

        // Log the data to the console for debugging
        \Log::info('Last calculations:', ['lastCalculations' => $lastCalculations]);

        // Return an Inertia view with the calculations data
        return inertia('LastCalculations', [
            'lastCalculations' => $lastCalculations,
        ]);
    }

}
