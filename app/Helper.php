<?php

namespace App;


use App\Models\File;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Faker\Generator;
use GuzzleHttp\Client;
use Illuminate\Container\Container;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Helper
{
    /**
     * dump
     *
     * @param mixed $value
     * @return bool|string
     */
    public static function dump($value)
    {
        return print_r($value);
    }

    /**
     * dd
     *
     * @param mixed $value
     */
    public static function dd($value)
    {
        return exit(print_r($value, true));
    }

    /**
     * uuid2hash
     *
     * @param string $uuid
     * @return string|null
     */
    public static function uuid2hash($uuid)
    {
        return !self::isNullOrEmpty($uuid) ? str_replace('-', '', $uuid) : null;
    }

    /**
     * isNullOrEmpty
     *
     * @param mixed $value
     * @return bool
     */
    public static function isNullOrEmpty($value)
    {
        return empty($value);
    }

    /**
     * hash2uuid
     *
     * @param string $hash
     * @return string|null
     */
    public static function hash2uuid($hash)
    {
        if (self::isNullOrEmpty($hash)) {
            return null;
        }
        $parts[] = Str::substr($hash, 0, 8);
        $parts[] = Str::substr($hash, 8, 4);
        $parts[] = Str::substr($hash, 12, 4);
        $parts[] = Str::substr($hash, 16, 4);
        $parts[] = Str::substr($hash, 20, 12);
        return implode('-', $parts);
    }

    /**
     * prettyPhone
     *
     * @param string $value
     * @return string
     */
    public static function cleanPhone($value)
    {
        return preg_replace('/[^0-9]/', '', $value);
    }

    /**
     * prettyPhone
     *
     * @param string $value
     * @return string
     */
    public static function prettyPhone($value)
    {
        $parts = [];
        $parts[0] = Str::substr($value, 0, 1);
        $parts[1] = Str::substr($value, 1, 3);
        $parts[2] = Str::substr($value, 4, 3);
        $parts[3] = Str::substr($value, 7, 2);
        $parts[4] = Str::substr($value, 9, 2);
        return '+' . $parts[0] . ' (' . $parts[1] . ') ' . $parts[2] . '-' . $parts[3] . '-' . $parts[4];
    }

    /**
     * isBase64Image
     *
     * @param string $value
     * @return bool
     */
    public static function isBase64Image($value)
    {
        return Str::startsWith($value, 'data:image');
    }

    /**
     * uploadBase64Image
     *
     * @param string $value
     * @param string $disk
     * @param string $path
     * @return File
     */
    public static function uploadBase64Image($value, $disk, $path = null)
    {
        $data = Str::before($value, ';base64,');
        $base64 = Str::after($value, ';base64,');
        $ext = Str::after($data, 'data:image/');
        $filename = (string)Str::uuid() . '.' . $ext;
        $blob = base64_decode($base64);

        $image = new File();
        $image->name = $image->original = $filename;
        $image->size = strlen($blob);
        $image->type = Arr::get(config('mimetypes'), $ext);
        $image->disk = $disk;
        $image->path = $path;
        $disk = $image->disk;
        self::disk($disk)->put(implode('/', [$path, $filename]), $blob);
        $image->save();
        return $image;
    }

    public static function disk($name)
    {
        return Storage::disk($name);
    }

    public static function base64url_decode($data, $strict = false)
    {
        // Convert Base64URL to Base64 by replacing “-” with “+” and “_” with “/”
        $b64 = strtr($data, '-_', '+/');

        // Decode Base64 string and return the original data
        return base64_decode($b64, $strict);
    }

    public static function UUID4($data = null)
    {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);

        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }


    /**
     * saveExistingFile
     *
     * @param string $filepath
     * @param string $disk
     * @param string $path
     * @return File
     */
    public static function saveExistingFile($filepath, $disk = 'public', $path = null)
    {
        $blob = file_get_contents($filepath);
        list($dirname, $basename, $extension, $filename) = array_values(pathinfo($filepath));
        $file = new File();
        $file->original = $basename;
        $file->name = (string)Str::uuid() . '.' . $extension;
        $file->size = strlen($blob);
        $file->type = Arr::get(config('mimetypes'), $extension);
        $file->disk = $disk;
        $file->path = $path;
        self::disk($disk)->put(implode('/', [$path, $file->name]), $blob);
        $file->save();
        return $file;
    }

    public static function saveFileFromUrl($url, $disk = 'public', $path = '')
    {
    }

    public static function uploadFileFromRequest(UploadedFile $uploadedFile, $disk = 'public', $path = null): File
    {
        $extension = config('mimetypes')[$uploadedFile->getExtension() ?: $uploadedFile->getClientOriginalExtension()];
        $filename = Str::uuid() . '.' . $uploadedFile->getClientOriginalExtension();
        Storage::disk($disk)->put(implode('/', [$path, $filename]), fopen($uploadedFile, 'r+'));
        $file = new File();
        $file->name = $filename;
        $file->disk = $disk;
        $file->path = $path;
        $file->type = $uploadedFile->getMimeType() ?? $uploadedFile->getClientMimeType();
        $file->original = $uploadedFile->getClientOriginalName();
        $file->size = $uploadedFile->getSize();
        $file->save();
        return $file;
    }


    /**
     * @return Generator
     */
    public static function faker()
    {
        return Container::getInstance()->make(Generator::class);
    }

    /**
     * genTimes
     *
     * @param mixed $begin
     * @param mixed $end
     * @return Collection
     */
    public static function genTimes($begin = 0, $end = 24, $time2datetime = false)
    {
        $times = collect();
        for ($i = $begin; $i < $end; $i++) {
            $times->push($i * 60);
        }
        return $times;
    }

    /**
     * genPeriod
     *
     * @param int $days
     * @return Collection
     */
    public static function genPeriod($days = 14, $addDays = 0)
    {
        return collect(CarbonPeriod::create(today()->addDays($addDays), today()->addDays($days))->toArray());
    }

    /**
     * dateTime2Carbon
     *
     * @param Carbon|string $date
     * @param int $time
     * @return Carbon
     */
    public static function dateTime2Carbon($date, $time, $tz = 'UTC')
    {
        if (!$date instanceof Carbon) {
            $date = Carbon::parse($date);
        }
        return self::intTime2Carbon($time, $date, $tz);
    }

    /**
     * intTime2Carbon
     *
     * @param int $time
     * @param Carbon|null $date
     * @return Carbon
     */
    public static function intTime2Carbon($time, $date = null, $tz = 'UTC')
    {
        $date = $date ?? today($tz);
        return Carbon::createFromTimestamp($date->timestamp + $time * 60, $tz);
    }


    public static function getNearestTzOffset($tz_offset)
    {
        $modulo = $tz_offset % 3600;
        if ($modulo == 0) {
            return $tz_offset;
        }
        $diff = 3600 % $modulo;
        if ($modulo < 0) {
            $tz_offset -= $diff;
        } else {
            $tz_offset += $diff;
        }
        return $tz_offset;
    }

    public static function tzOffsetToString($tz_offset)
    {
        $hours = $tz_offset / 3600;
        $sign = $tz_offset < 0 ? '-' : '+';
        $hours = abs($hours);
        $hours = $hours < 10 ? '0' . $hours : $hours;
        return $sign . $hours . ':00';
    }

    public static function tzOffsetToNumber($tz_offset)
    {
        return $tz_offset / 3600;
    }

    public static function notify($text = 'Опа, не указал текст сообщения')
    {
        $text = 'Проект: VKT' . PHP_EOL . PHP_EOL . $text;
        $url = 'https://api.telegram.org/bot336380108:AAHnj-kKSUkUXkJzuXPdXfePshoYGXrNcxQ/sendMessage?chat_id=174759132&text=' . $text;

        $http = new Client();
        $http->get($url);
    }

    /**
     * @param $number
     * @return string
     */
    public static function formatPrice($number): string
    {
        return number_format($number, 2, ',', ' ') . ' руб.';
    }

    public static function getHierarchy($node, $nodes, $childKey, $parentKey, $primaryKey)
    {
        $childrens = $nodes->where($parentKey, $node[$primaryKey])->values();
        if ($childrens->isNotEmpty()) {
            if ($nodes instanceof \Illuminate\Database\Eloquent\Collection) {
                $node->setRelation($childKey, $childrens);
                $node->relationLoaded($childKey);
            } else {
                $node[$childKey] = $childrens;
            }
            foreach ($node[$childKey] as &$child) {
                self::getHierarchy($child, $nodes, $childKey, $parentKey, $primaryKey);
            }
        }
    }

    public static function getMeasure($measure_id = null)
    {
        $measures = [
            0 => 'шт.',
            1 => 'г.',
            2 => 'кг.',
            3 => 'т.',
            4 => 'см',
            5 => 'дц',
            6 => 'м',
            7 => 'кв. см.',
            8 => 'кв. дц.',
            9 => 'кв. м.',
            10 => 'мл',
            11 => 'л',
            12 => 'м3',
            13 => 'квт/ч',
        ];

        if (is_null($measure_id)) {
            return $measures;
        } else {
            return $measures[$measure_id];
        }
    }

    public static function plural($n, $one, $two, $five)
    {
        $forms = [
            $one, $two, $five
        ];
        return $n % 10 == 1 && $n % 100 != 11 ? $forms[0] : ($n % 10 >= 2 && $n % 10 <= 4 && ($n % 100 < 10 || $n % 100 >= 20) ? $forms[1] : $forms[2]);
    }

    /**
     * Удаляет решетку из стрики с цветом
     * @param string|null $text
     * @return string
     */
    public static function formatColor(?string $text): string
    {
        return Str::replace('#', '', $text);
    }

    public static function vardump($arr, $var_dump = false)
    {
        echo "<pre style='background: #222;color: #54ff00;padding: 20px; z-index: 10000'>";
        if ($var_dump) var_dump($arr);
        else print_r($arr);
        echo "</pre>";
    }

    public static function downloadWithBasicAuth(string $url): bool|string
    {
        $auth = base64_encode("basicuser:" . config('app.xml_auth_password'));
        $context = stream_context_create([
            "http" => [
                "header" => "Authorization: Basic $auth"
            ]
        ]);

        $content = file_get_contents($url, false, $context);
        return $content;
    }
}
