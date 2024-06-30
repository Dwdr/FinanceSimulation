<?php

namespace App\Http\Livewire\EH\SystemSettings\Backup;

use App\Models\System\Backup;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\Process\Process;

class Index extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['alert' => 'alertHandle'];

    public function alertHandle($alert)
    {
        session()->flash($alert['type'], $alert['message']);
    }

    public function render()
    {
        $backup = Backup::orderBy('created_at','desc')->paginate(10);
        return view('livewire.eh.system_settings.backup.index',[
            'backup' => $backup
        ]);
    }

    public function restore($uuid) {
        $backup = Backup::findOrFail($uuid);
//        $mysql_file = base_path().'/'.$backup->file['file_path'].$backup->file['file_name'];

        $ds = DIRECTORY_SEPARATOR;
        $storage_path = $backup->file['file_path'].$backup->file['file_name'];

        $mysql_file = base_path() . $ds . 'storage' . $ds .'app'. $ds . 'private' . $ds . $storage_path;

        $path_project = base_path();
        $path_script = base_path() . '/resources/scripts/restore_mysql.sh';

        $process = Process::fromShellCommandline("(cd $path_project; sh $path_script $mysql_file) ");
        $process->run();

        if (!$process->isSuccessful()) {
            $alert = [
                'type' => 'alert-danger',
                'message' => 'Restore process fail.'
            ];
            \Log::info('[FAIL] backup_mysql: ' . $process);
            $this->emit('alert', $alert);
        }

        $alert = [
            'type' => 'alert-success',
            'message' => 'Restore Data success.'
        ];
        $this->emit('alert', $alert);
    }
}
