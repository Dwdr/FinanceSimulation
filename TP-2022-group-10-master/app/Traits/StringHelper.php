<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

trait StringHelper
{

    protected $fileTypes = [
        'image'      => 'png|jpg|jpeg|tmp|gif',
        'word'       => 'doc|docx',
        'excel'      => 'xls|xlsx|csv',
        'powerpoint' => 'ppt|pptx',
        'pdf'        => 'pdf',
        'code'       => 'php|js|java|python|ruby|go|c|cpp|sql|m|h|json|html|aspx',
        'archive'    => 'zip|tar\.gz|rar|rpm',
        'txt'        => 'txt|pac|log|md',
        'audio'      => 'mp3|wav|flac|3pg|aa|aac|ape|au|m4a|mpc|ogg',
        'video'      => 'mkv|rmvb|flv|mp4|avi|wmv|rm|asf|mpeg',
    ];

    /**
     * @param $name
     * @return \Illuminate\Support\Stringable
     * name[index] -> name_index
     */
    public static function removeNameArray($name): string {
            return Str::of($name)->replace('[]','')->replace('[','_')->remove(']');
    }

    /**
     * @param $data
     * @param $key
     * @return bool
     */
    public function checkbox2boolean($data, $key): bool {
        return (isset($data[$key]) && $data[$key] == 'on');
    }

    /**
     * @param $size
     * @param string $unit
     * @return string
     */
    public function humanFileSize($size, $unit=""): string {
        if( (!$unit && $size >= 1<<30) || $unit == "GB")
            return number_format($size/(1<<30),2)."GB";
        if( (!$unit && $size >= 1<<20) || $unit == "MB")
            return number_format($size/(1<<20),2)."MB";
        if( (!$unit && $size >= 1<<10) || $unit == "KB")
            return number_format($size/(1<<10),2)."KB";
        return number_format($size)." bytes";
    }

    /**
     * Get file icon.
     *
     * @param string $file
     *
     * @return string
     */
    public function getFileIcon($file_extension)
    {
        $extension = $file_extension;

        foreach ($this->fileTypes as $type => $regex) {
            if (preg_match("/^($regex)$/i", $extension) !== 0) {
                return "fa-file-{$type}";
            }
        }

        return 'fa-file-o';
    }
}
