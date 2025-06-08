<?php

namespace App\Jobs;

use App\Models\Cow;
use App\Enums\CowStatus;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AnalyzeCowHealth implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Cow $cow;

    public function __construct(Cow $cow)
    {
        $this->cow = $cow;
    }

    public function handle(): void
    {
        $now = now();

        /*** === PARTO IMINENTE === ***/
        $oneHourAgo = $now->copy()->subHour();
        $zAxis = $this->cow->accelerometerDatas()
            ->where('created_at', '>=', $oneHourAgo)
            ->orderBy('created_at')
            ->pluck('accel_z');

        $mudancasPosturais = 0;
        for ($i = 1; $i < $zAxis->count(); $i++) {
            if (abs($zAxis[$i] - $zAxis[$i - 1]) > 0.5) {
                $mudancasPosturais++;
            }
        }

        $mediaFC = $this->cow->heartRateDatas()
            ->latest()
            ->take(30)
            ->pluck('bpm')
            ->avg();

        $twelveHoursAgo = $now->copy()->subHours(12);
        $temperaturas = $this->cow->temperatureDatas()
            ->where('created_at', '>=', $twelveHoursAgo)
            ->pluck('temperature');

        $deltaTemp = 0;
        if ($temperaturas->count() >= 2) {
            $deltaTemp = $temperaturas->last() - $temperaturas->first();
        }

        if ($mudancasPosturais > 10 && $mediaFC > 90 && $deltaTemp < 0) {
            $this->cow->status = CowStatus::Parto;
            $this->cow->save();

            Notification::make()
                ->title('Atenção!')
                ->body('A vaca ' . $this->cow->name . ' está com indícios de parto iminente! Necessário verificação imediata.')
                ->icon('heroicon-o-shield-exclamation')
                ->actions([
                    Action::make('view')
                        ->label('Marcar como Lido')
                        ->color('secondary')
                        ->button()
                        ->markAsRead(),
                ])
                ->iconColor('warning')
                ->sendToDatabase(User::all());
        }

        /*** === ESTRESSE TÉRMICO === ***/
        $fiveMinutesAgo = $now->copy()->subMinutes(30);

        $accelData = $this->cow->accelerometerDatas()
            ->where('created_at', '>=', $fiveMinutesAgo)
            ->orderBy('created_at')
            ->get(['accel_x', 'accel_y']);

        $picosInquietos = 0;
        for ($i = 1; $i < $accelData->count(); $i++) {
            $deltaX = abs($accelData[$i]->accel_x - $accelData[$i - 1]->accel_x);
            $deltaY = abs($accelData[$i]->accel_y - $accelData[$i - 1]->accel_y);

            if ($deltaX > 0.8 || $deltaY > 0.8) {
                $picosInquietos++;
            }
        }

        $temperaturaAtual = $this->cow->temperatureDatas()
            ->latest()
            ->take(30)
            ->pluck('temperature')
            ->avg();

        $frequenciaCardiacaAtual = $this->cow->heartRateDatas()
            ->latest()
            ->take(30)
            ->pluck('bpm')
            ->avg();

        if (
            $temperaturaAtual > 39.0 &&
            $frequenciaCardiacaAtual > 100 &&
            $picosInquietos > 15
        ) {
            $this->cow->status = CowStatus::Termico;
            $this->cow->save();

            Notification::make()
                ->title('Atenção!')
                ->body('A vaca ' . $this->cow->name . ' está com indícios de estresse térmico! Necessário verificação imediata.')
                ->icon('heroicon-o-shield-exclamation')
                ->actions([
                    Action::make('view')
                        ->label('Marcar como Lido')
                        ->color('secondary')
                        ->button()
                        ->markAsRead(),
                ])
                ->iconColor('warning')
                ->sendToDatabase(User::all());
        }
    }
}

