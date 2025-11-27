<?php

use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

if (! function_exists('validate')) {
    function validate(array $data, array $rules, array $messages = [], array $attributes = [])
    {
        return validator($data, $rules, $messages, $attributes)->validate();
    }
}

if (! function_exists('transaction')) {
    function transaction(Closure $callback, int $attempts = 3)
    {
        if (DB::transactionLevel() > 0) {
            return $callback();
        }

        return DB::transaction($callback, $attempts);
    }
}


if (! function_exists('__date')) {
    function __date(Carbon|string|null $value): ?string
    {
        if (is_null($value)) {
            return null;
        }

        if (is_string($value)) {
            $value = new Carbon($value);
        }

        return $value->format('d.m.Y H:i');
    }
}

if (! function_exists('filament_model_resource')) {
    /**
     * @return class-string<resource>|null
     */
    function filament_model_resource(Model $model): ?string
    {
        return Filament::getCurrentOrDefaultPanel()?->getModelResource($model);
    }
}

if (! function_exists('show_validation_errors')) {
    function show_validation_errors(Closure $callback)
    {
        try {
            return $callback();
        } catch (ValidationException $exception) {
            $message = $exception->getMessage();

            if (app()->isLocal()) {
                foreach ($exception->getTrace() as $call) {
                    if (str_starts_with($call['file'], app_path())) {
                        $class = class_basename($call['file']);
                        $line = $call['line'];
                        $message .= "\n$class:$line";

                        break;
                    }
                }
            }

            Notification::make()
                ->title(__('Ошибка валидации'))
                ->body($message)
                ->danger()
                ->seconds(40)
                ->send();

            throw $exception;
        }
    }
}

// получить uuid
if (! function_exists('uuid')) {
    function uuid(): string
    {
        return (string) Str::uuid();
    }
}

if (! function_exists('bytes_format')) {
    function bytes_format(int $bytes): string
    {
        $result = $bytes ? $bytes / 1024 / 1024 : 0;
        return (int) $result;
    }
}

if (! function_exists('event_if')) {
    function event_if(bool $condition, ...$args)
    {
        $condition && event(...$args);
    }
}

if (! function_exists('tg_url')) {
    function tg_url(string $bot_name, ?string $ref_code = null): string
    {
        $url = "https://t.me/{$bot_name}";
        if ($ref_code) {
            $url .= "?start={$ref_code}";
        }
        return $url;
    }
}

if (! function_exists('fingerprint')) {
    function fingerprint(array $attributes)
    {
        ksort($attributes);

        return sha1(json_encode($attributes, JSON_UNESCAPED_UNICODE));
    }
}

if (! function_exists('get_env_id')) {
    function get_env_id(string $value)
    {
        if (app()->isProduction()) {
            return $value;
        }

        $env = app()->environment();

        $id = str_replace($env, '', $value);

        if (is_numeric($id)) {
            return (int) $id;
        }

        return null;
    }
}

if (! function_exists('permission_key')) {
    function permission_key($model, string $method): string
    {
        $model = (is_object($model) ? get_class($model) : $model);
        $model = class_basename($model);

        return "{$model}:{$method}";
    }
}

// привести значение к типу (cast)
if (! function_exists('cast_value')) {
    function cast_value(string $cast, mixed $value = null): mixed
    {
        if (is_null($value) || $value === '') {
            return null;
        }

        return match ($cast) {
            'bool', 'boolean' => to_bool($value),
            'date', 'datetime' => new Carbon($value),
            'array' => is_string($value) ? json_decode($value, true) : (array) $value,
            'int', 'integer' => (int) $value,
            'float' => (float) $value,
            default => $value,
        };
    }
}

// привести значение к boolean
// 'true' => true, 'false' => false
if (! function_exists('to_bool')) {
    function to_bool(bool|string|int $value): bool
    {
        if (is_bool($value)) {
            return $value;
        }

        if (is_string($value)) {
            if ($value === 'true') {
                return true;
            }

            if ($value === 'false') {
                return false;
            }
        }

        return (bool) $value;
    }
}
