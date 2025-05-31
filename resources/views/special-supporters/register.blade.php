<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full space-y-8 bg-white p-6 rounded-xl shadow-lg">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Registro de Especiales
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Por favor, completa todos los pasos para registrarte
                </p>
            </div>

            <div class="mt-8">
                <!-- Progress Bar -->
                <div class="relative pt-1">
                    <div class="flex mb-2 items-center justify-between">
                        <div class="text-right">
                            <span class="text-xs font-semibold inline-block text-blue-600" id="progress-text">
                                Paso 1 de 3
                            </span>
                        </div>
                    </div>
                    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-blue-200">
                        <div id="progress-bar" class="w-1/3 shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500 transition-all duration-500"></div>
                    </div>
                </div>

                <form id="registrationForm" action="{{ route('special.register.submit', $supporter->registration_token) }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Step 1: Name -->
                    <div id="step1" class="step">
                        <div class="rounded-md shadow-sm -space-y-px">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                                <input id="name" name="name" type="text" required 
                                    class="mt-1 appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                                    placeholder="Enter your full name">
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="button" onclick="nextStep(1)" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Siguiente
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Location -->
                    <div id="step2" class="step hidden">
                        <div class="rounded-md shadow-sm -space-y-px space-y-4">
                            <div>
                                <label for="state" class="block text-sm font-medium text-gray-700">Estado</label>
                                <input id="state" name="state" type="text" required 
                                    class="mt-1 appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                                    placeholder="Enter your state">
                            </div>
                            <div class="pt-4">
                                <label for="municipality" class="block text-sm font-medium text-gray-700">Municipio</label>
                                <input id="municipality" name="municipality" type="text" required 
                                    class="mt-1 appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                                    placeholder="Enter your municipality">
                            </div>
                        </div>
                        <div class="mt-4 flex justify-between">
                            <button type="button" onclick="prevStep(2)" class="group relative w-5/12 flex justify-center py-2 px-4 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Anterior
                            </button>
                            <button type="button" onclick="nextStep(2)" class="group relative w-5/12 flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Siguiente
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Goal -->
                    <div id="step3" class="step hidden">
                        <div class="rounded-md shadow-sm -space-y-px">
                            <div>
                                <label for="mobilized_goal" class="block text-sm font-medium text-gray-700">Objetivo de Movilización</label>
                                <input id="mobilized_goal" name="mobilized_goal" type="number" required min="1"
                                    class="mt-1 appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                                    placeholder="Enter your mobilization goal">
                            </div>
                        </div>
                        <div class="mt-4 flex justify-between">
                            <button type="button" onclick="prevStep(3)" class="group relative w-5/12 flex justify-center py-2 px-4 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Anterior
                            </button>
                            <button type="submit" class="group relative w-5/12 flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Completar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let currentStep = 1;
        const totalSteps = 3;

        function updateProgress() {
            const progressBar = document.getElementById('progress-bar');
            const progressText = document.getElementById('progress-text');
            const progress = (currentStep / totalSteps) * 100;
            
            progressBar.style.width = `${progress}%`;
            progressText.textContent = `Step ${currentStep} of ${totalSteps}`;
        }

        function showStep(step) {
            document.querySelectorAll('.step').forEach(s => s.classList.add('hidden'));
            document.getElementById(`step${step}`).classList.remove('hidden');
            currentStep = step;
            updateProgress();
        }

        function validateStep(step) {
            let valid = true;
            const inputs = document.getElementById(`step${step}`).querySelectorAll('input');
            inputs.forEach(input => {
                if (!input.value) {
                    valid = false;
                    input.classList.add('border-red-500');
                } else {
                    input.classList.remove('border-red-500');
                }
            });
            return valid;
        }

        function nextStep(currentStepNum) {
            if (validateStep(currentStepNum)) {
                showStep(currentStepNum + 1);
            }
        }

        function prevStep(currentStepNum) {
            showStep(currentStepNum - 1);
        }
    </script>
</body>
</html> 