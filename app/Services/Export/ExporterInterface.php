<?php

namespace App\Services\Export;

use App\Models\User;

interface ExporterInterface
{
    /** @return array{string, string} path to file and its public name */
    public function export(User $user, int $year, int $month): array;
}
