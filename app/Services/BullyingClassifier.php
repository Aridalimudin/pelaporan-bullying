<?php

namespace App\Services;

use App\Models\ViolationType;

class BullyingClassifier
{
    public function classify(string $deskripsi, ?string $manualIds = null): array
    {
        $deskripsi  = strtolower($deskripsi);
        $violations = ViolationType::all();
        $detected   = [];
        $totalScore = 0;

        foreach ($violations as $vt) {
            if ($this->matchesViolation($deskripsi, $vt)) {
                $detected[$vt->id] = $vt;
                $totalScore += $vt->weight;
            }
        }

        if (!empty($manualIds)) {
            $ids = array_filter(array_map('intval', explode(',', $manualIds)));
            foreach ($violations->filter(fn($vt) => in_array($vt->id, $ids)) as $vt) {
                if (!isset($detected[$vt->id])) {
                    $detected[$vt->id] = $vt;
                    $totalScore += $vt->weight;
                }
            }
        }

        return [
            'violations'    => array_values($detected),
            'violation_ids' => array_keys($detected),
            'score'         => $totalScore,
            'urgency'       => $this->determineUrgency($totalScore),
        ];
    }

    private function matchesViolation(string $deskripsi, ViolationType $vt): bool
    {
        foreach ($vt->getKeywordsArray() as $keyword) {
            if (str_contains($deskripsi, strtolower(trim($keyword)))) {
                return true;
            }
        }

        if (str_contains($deskripsi, strtolower($vt->name))) {
            return true;
        }

        $nameWords = array_filter(
            explode(' ', strtolower($vt->name)),
            fn($w) => mb_strlen($w) >= 4
        );
        foreach ($nameWords as $word) {
            if (str_contains($deskripsi, $word)) {
                return true;
            }
        }

        return false;
    }

    private function determineUrgency(int $score): string
    {
        if ($score <= 0) return 'rendah';
        if ($score <= 4) return 'rendah';  // 1-4 = Ringan
        if ($score <= 8) return 'sedang';  // 5-8 = Sedang
        return 'tinggi';                   // >9  = Tinggi
    }
}