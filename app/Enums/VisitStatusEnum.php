<?php

namespace App\Enums;


enum VisitStatusEnum: string
{
    case SCHEDULED   = 'scheduled';
    case VISITED     = 'visited';
    case NOT_VISITED  = 'not-visited';
    case CANCELED    = 'canceled';
    case RESCHEDULED = 'rescheduled';

    public function label()
    {
        return match ($this) {
            self::SCHEDULED => __('Scheduled'),
            self::VISITED => __('Visited'),
            self::NOT_VISITED => __('Not Visited'),
            self::CANCELED => __('Canceled'),
            self::RESCHEDULED => __('Rescheduled'),
        };
    }

    public static function keyValuesCombined(): array
    {
        return array_combine(
            array_column(self::cases(), 'value'),
            array_map(fn($case) => $case->label(), self::cases())
        );
    }

    public static function colors()
    {
        return array_combine(
            array_column(self::cases(), 'value'),
            ['#3788d8', '#10b981', '#ef4444', '#ef4444', '#f59e0b']
        );
    }

    /**
     * Return the final statuses. Final statuses are the statuses that are considered
     * as the final result of a visit.
     *
     * @param string $returnType The type of the return value. Can be 'enum' or 'string'.
     * @param array $additionalStatuses Additional statuses to include in the result.
     * @return array The final statuses.
     */
    public static function finalStatuses(string $returnType = 'enum', array $additionalStatuses = []): array
    {
        static $baseStatuses = null;
        $baseStatuses ??= [self::VISITED, self::NOT_VISITED, self::CANCELED];

        return match ($returnType) {
            'enum' => self::handleEnumReturn($baseStatuses, $additionalStatuses),
            'string' => self::handleValuesReturn($baseStatuses, $additionalStatuses),
            default => throw new \InvalidArgumentException(
                "Invalid return type: {$returnType}. Expected 'enum' or 'string'"
            )
        };
    }

    /**
     * Processes and returns a combined array of base and additional enum statuses.
     *
     * @param array $baseStatuses The base statuses to start with.
     * @param array $additionalStatuses Additional statuses to be added.
     * @return array The combined array of base and additional statuses.
     * @throws \InvalidArgumentException If any of the additional statuses are not instances of the enum.
     */
    private static function handleEnumReturn(array $baseStatuses, array $additionalStatuses): array
    {
        // Return base statuses if no additional statuses are provided
        if (empty($additionalStatuses)) {
            return $baseStatuses;
        }

        // Verify that all additional statuses are instances of the enum
        foreach ($additionalStatuses as $status) {
            if (!$status instanceof self) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'Invalid enum value: %s. Expected instance of %s',
                        is_object($status) ? get_class($status) : gettype($status),
                        static::class
                    )
                );
            }
        }

        // Return the combined array of base and additional statuses
        return [...$baseStatuses, ...$additionalStatuses];
    }

    /**
     * Processes and returns a combined array of base and additional status values.
     *
     * @param array $baseStatuses The base statuses to start with.
     * @param array $additionalStatuses Additional statuses to be added.
     * @return array The combined array of base and additional status values.
     */
    private static function handleValuesReturn(array $baseStatuses, array $additionalStatuses): array
    {
        static $baseValues = null;

        // Convert additional statuses to their respective values if they are enum instances
        $additionalStatuses = array_map(fn($status) => $status instanceof self ? $status->value : $status, $additionalStatuses);

        // Initialize base values array if not already done
        $baseValues ??= array_column(array_map(fn($enum) => ['value' => $enum->value], $baseStatuses), 'value');

        // Return the combined array of base and additional status values
        return empty($additionalStatuses)
            ? $baseValues
            : [...$baseValues, ...$additionalStatuses];
    }
}
