<?php

namespace App\Http\Livewire\EH\SystemSettings\Backup;

use App\Models\System\Backup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class IndexPanel extends Component {
    public function render() {
        return view('livewire.eh.system_settings.backup.index-panel');
    }

    public function backup() {

        $path_project = base_path();
        $path_script = base_path() . '/resources/scripts/backup_mysql.sh';

        $ds = DIRECTORY_SEPARATOR;
//        $host = env('DB_HOST');
//        $username = env('DB_USERNAME');
//        $password = env('DB_PASSWORD');
//        $database = env('DB_DATABASE');

        $ts = time();
        $path = database_path() . $ds . 'backups' . $ds . date('Y', $ts) . $ds . date('m', $ts) . $ds . date('d', $ts) . $ds;

        $storage_path = 'backups' . $ds .'eh'. $ds . Auth::user()->profile->organization->name_slug . $ds . date('Y', $ts) . $ds . date('m', $ts) . $ds . date('d', $ts) . $ds;

        $path = base_path() . $ds . 'storage' . $ds .'app'. $ds . 'private' . $ds . $storage_path;
//        $file = date('Y-m-d-His', $ts) . '-dump-' . $database . '.sql';

        $process = Process::fromShellCommandline("(cd $path_project; sh $path_script $path) ");
        $process->run();

        if (!$process->isSuccessful()) {
            $alert = [
                'type' => 'alert-danger',
                'message' => 'Backup process fail.'
            ];
            \Log::info('[FAIL] backup_mysql: ' . $process);
            $this->emit('alert', $alert);
        }

        $output_file = $process->getOutput();

        Backup::create([
            'uuid' => Str::uuid(),
            'organization_id' => Auth::user()->profile->organization_id,
            'file' => serialize([
                'file_name' => $output_file,
                'file_source_name' => $output_file,
                'file_path' => $storage_path,
            ])
        ]);

        $alert = [
            'type' => 'message',
            'message' => 'Backup created.'
        ];
        $this->emit('alert', $alert);

    }

    public function restore() {
        $alert = [
            'type' => 'alert-info',
            'message' => 'TODO'
        ];
        $this->emit('alert', $alert);
    }
}
