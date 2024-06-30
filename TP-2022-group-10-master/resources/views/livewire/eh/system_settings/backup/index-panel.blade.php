<div class="card">
    <div class="card-body">
        <button class="btn btn-primary" wire:click.prevent="backup" wire:loading.attr="disabled" wire:target="backup">
            <div wire:loading.remove wire:target="backup">
                Create Backup
            </div>
            <div wire:loading wire:target="backup">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Creating...
            </div>
        </button>

{{--        <button class="btn btn-primary" wire:click.prevent="restore" wire:loading.attr="disabled" wire:target="restore">--}}
{{--            <div wire:loading.remove wire:target="restore">--}}
{{--                Restore Backup--}}
{{--            </div>--}}
{{--            <div wire:loading wire:target="restore">--}}
{{--                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>--}}
{{--                Loading...--}}
{{--            </div>--}}
{{--        </button>--}}
    </div>
</div>
