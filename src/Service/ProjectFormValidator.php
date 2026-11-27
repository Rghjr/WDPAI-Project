<?php

declare(strict_types=1);

namespace App\Service;

final class ProjectFormValidator
{
    /** @var list<string> */
    private const STATUSES = ['PLANNED', 'ACTIVE', 'COMPLETED', 'CANCELLED'];

    /**
     * @param array<string, mixed> $input
     * @return array{data: array{title: string, description: ?string, status: string}, errors: array<string, string>}
     */
    public function validate(array $input): array
    {
        $title = trim((string) ($input['title'] ?? ''));
        $description = trim((string) ($input['description'] ?? ''));
        $status = strtoupper(trim((string) ($input['status'] ?? 'PLANNED')));
        $errors = [];

        if ($title === '') {
            $errors['title'] = 'Tytuł projektu jest wymagany.';
        } elseif (mb_strlen($title) > 180) {
            $errors['title'] = 'Tytuł projektu może mieć maksymalnie 180 znaków.';
        }

        if (!in_array($status, self::STATUSES, true)) {
            $errors['status'] = 'Wybierz poprawny status projektu.';
        }

        return [
            'data' => [
                'title' => $title,
                'description' => $description === '' ? null : $description,
                'status' => $status,
            ],
            'errors' => $errors,
        ];
    }

    /** @return list<string> */
    public function statuses(): array
    {
        return self::STATUSES;
    }
}
