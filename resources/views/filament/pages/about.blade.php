<x-filament::page>
    <div class="prose max-w-none">
        <p>
            Este sistema foi desenvolvido para facilitar o monitoramento de vacas leiteiras através de colares inteligentes conectados a sensores.
        </p>

        <p>
            A aplicação coleta, armazena e exibe dados em tempo real sobre:
        </p>

        <ul>
            <li>Frequência cardíaca (sensor MAX30102)</li>
            <li>Temperatura corporal (sensor MLX90614)</li>
            <li>Movimentação e atividade (sensor MPU6050)</li>
        </ul>

        <p>
            Cada colar é vinculado a uma vaca e envia os dados para o sistema via protocolo MQTT, que são então processados e armazenados em um banco de dados relacional.
        </p>

        <p>
            O sistema foi desenvolvido com:
        </p>

        <ul>
            <li>Laravel 11</li>
            <li>Filament v3</li>
            <li>PHP 8.3</li>
            <li>MySQL</li>
        </ul>

        <div class="mt-6 p-4 bg-gray-100 rounded-xl border border-gray-300 shadow-sm">
            <p class="text-sm text-gray-700">
                💡 Este projeto é parte de um estudo de aplicações modernas em IoT no agronegócio, com foco na saúde e bem-estar animal.
            </p>
        </div>

        <p class="mt-6 text-sm text-gray-500">
            Desenvolvido por Fernando Alonso, Ângelo Piovezan, Jafte Fagundes e Renato Gouveia, 2025.
        </p>
    </div>
</x-filament::page>
