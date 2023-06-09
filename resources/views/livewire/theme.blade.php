<div class="w-full h-full flex flex-row justify-center">
    <div class="self-center dark:bg-gray-400 bg-gray-500 rounded p-12">
        <h1 class="font-nuni font-bold text-9xl dark:text-gray-50">
            Restaurante Badajoz
        </h1>
        <p class="dark:text-yellow-200 text-yellow-500">Proyecto desarrollado por Rubén Núñez Cotano, María Esperanza Pérez Martín y Fernando Casco Claver</p>
        <label for="Toggle2" class="inline-flex items-center space-x-4 cursor-pointer dark:text-gray-100">
            <span>Light</span>
            <span class="relative">
                        <input id="Toggle2" type="checkbox" class="hidden peer" onclick="changeMode()">
                        <div class="w-10 h-4 rounded-full shadow dark:bg-gray-600 peer-checked:dark:bg-violet-400 peer-checked:bg-yellow-600"></div>
                        <div class="absolute left-0 w-6 h-6 rounded-full shadow -inset-y-1 peer-checked:right-0 peer-checked:left-auto dark:bg-yellow-400 bg-yellow-400"></div>
	                </span>
            <span>Dark</span>
        </label>
        <br/>
        <label for="showAgain" class="dark:text-gray-100">
            Mantener tema del sistema
        </label>
        <input onclick="sistema()" type="checkbox" name="showAgain" id="showAgain" class="rounded-sm focus:ring-yellow-400 focus:dark:border-yellow-400 focus:ring-2 accent-yellow-400">
    </div>
</div>
