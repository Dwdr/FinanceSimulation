<div>
    <div class="card">
        <div class="card-header text-center">
            Test Email
        </div>
        <div class="card-body text-center">
            <button class="btn bg-olive w-50" wire:click.prevent="sendEmail" wire:loading.attr="disabled">
                <div wire:loading.remove>
                    Run
                </div>
                <div wire:loading>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </div>
            </button>
        </div>
    </div>
</div>
