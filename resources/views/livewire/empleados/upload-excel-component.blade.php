<div class="card rounded shadow">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <form wire:submit="guardar">
                    <div class="mb-3">
                      <label for="" class="form-label">Cargar Excel</label>
                      <input type="file"
                        class="form-control" wire:model.live="file">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Cargar</button>
                    </div>
                </form>
            </div>
            <div class="col-md-12"></div>
        </div>
    </div>
</div>
